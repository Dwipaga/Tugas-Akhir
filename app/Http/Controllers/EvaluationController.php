<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class EvaluationController extends Controller
{
    public function index()
    {
        $userGroupId = Auth::user()->group_id;
        $currentMonth = Carbon::now()->startOfMonth();

        // Get unique asesi_id groups where the current user is an asesor
        $penilaians = Penilaian::select('asesi_id')
            ->where('asesor_id', $userGroupId)
            ->where('is_active', true)
            ->groupBy('asesi_id')
            ->with(['asesi' => function ($query) {
                $query->select('group_id', 'group_name');
            }])
            ->get();

        // Get users who belong to these asesi groups
        $asesiUsers = User::whereIn('group_id', $penilaians->pluck('asesi_id'))
            ->select('user_id', 'firstname', 'group_id')
            ->get();

        // Check evaluation status for each user
        $asesiUsers->each(function ($user) use ($currentMonth) {
            $user->has_evaluation = Evaluation::where('asesi_ternilai_id', $user->user_id)
                ->where('penilai_id', Auth::user()->user_id)
                ->where('bulan_penilaian', $currentMonth)
                ->exists();
        });

        // Map group names to users
        $groupNames = $penilaians->pluck('asesi.group_name', 'asesi_id')->toArray();
        $asesiUsers->each(function ($user) use ($groupNames) {
            $user->group_name = $groupNames[$user->group_id] ?? 'N/A';
        });

        // Get evaluation results for assessed users (hasil penilaian yang sudah dinilai)
        $evaluationResults = Evaluation::with([
            'asesi' => function ($query) {
                $query->select('user_id', 'firstname', 'group_id');
            },
            'penilai' => function ($query) {
                $query->select('user_id', 'firstname');
            }
        ])
            ->where('penilai_id', Auth::user()->user_id)
            ->where('bulan_penilaian', $currentMonth)
            ->whereIn('asesi_ternilai_id', $asesiUsers->pluck('user_id'))
            ->select([
                'evaluation_id',
                'asesi_ternilai_id',
                'penilai_id',
                'total_score',
                'final_grade',
                'status',
                'bulan_penilaian',
                'created_at',
                'updated_at'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Optional: Get detailed evaluation items/criteria for each evaluation
        $evaluationDetails = [];
        if ($evaluationResults->isNotEmpty()) {
            $evaluationDetails = EvaluationDetail::with([
                'criteria' => function ($query) {
                    $query->select('criteria_id', 'criteria_name', 'max_score');
                }
            ])
                ->whereIn('evaluation_id', $evaluationResults->pluck('evaluation_id'))
                ->select([
                    'evaluation_detail_id',
                    'evaluation_id',
                    'criteria_id',
                    'score',
                    'comments'
                ])
                ->get()
                ->groupBy('evaluation_id');
        }

        return view('evaluations.index', compact(
            'penilaians',
            'asesiUsers',
            'evaluationResults',
            'evaluationDetails'
        ));
    }

    public function create($asesi_id)
    {
        $asesi = User::where('user_id', $asesi_id)->first();
        $penilai = Auth::user();
        $currentMonth = Carbon::now()->startOfMonth();

        // Check if evaluation already exists for this month
        $existingEvaluation = Evaluation::where('asesi_ternilai_id', $asesi->user_id)
            ->where('penilai_id', $penilai->user_id)
            ->where('bulan_penilaian', $currentMonth)
            ->exists();

        if ($existingEvaluation) {
            return redirect()->route('evaluations.index')
                ->with('error', 'Evaluation for this user has already been submitted for this month');
        }

        $penilaians = Penilaian::where('asesi_id', $asesi->group_id)
            ->where('asesor_id', $penilai->group_id)
            ->where('is_active', true)
            ->get();

        if ($penilaians->isEmpty()) {
            abort(403, 'Unauthorized: You are not allowed to evaluate this user');
        }

        return view('evaluations.create', compact('asesi', 'penilaians'));
    }

    public function store(Request $request, $asesi_id)
    {
        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'required|numeric|min:1|max:100'
        ]);

        $asesi = User::where('user_id', $asesi_id)->first();
        $penilai = Auth::user();
        $currentMonth = Carbon::now()->startOfMonth();

        // Double-check to prevent race conditions
        $existingEvaluation = Evaluation::where('asesi_ternilai_id', $asesi->id)
            ->where('penilai_id', $penilai->id)
            ->where('bulan_penilaian', $currentMonth)
            ->exists();

        if ($existingEvaluation) {
            return redirect()->route('evaluations.index')
                ->with('error', 'Evaluation for this user has already been submitted for this month');
        }

        $penilaians = Penilaian::where('asesi_id', $asesi->group_id)
            ->where('asesor_id', $penilai->group_id)
            ->where('is_active', true)
            ->get();

        $detail_penilaian = [];
        $total_score = 0;
        $total_bobot = 0;

        foreach ($penilaians as $penilaian) {
            $score = $request->scores[$penilaian->id];
            $detail_penilaian[] = [
                'penilaian_id' => $penilaian->id,
                'hasil' => $score
            ];
            $total_score += $score * $penilaian->bobot;
            $total_bobot += $penilaian->bobot;
        }

        $total_akhir = $total_bobot > 0 ? $total_score / $total_bobot : 0;

        Evaluation::create([
            'asesi_ternilai_id' => $asesi->user_id,
            'penilai_id' => $penilai->user_id,
            'detail_penilaian' => $detail_penilaian,
            'total_akhir' => $total_akhir,
            'bulan_penilaian' => $currentMonth
        ]);

        return redirect()->route('evaluations.index')
            ->with('success', 'Evaluation submitted successfully');
    }

    public function showEvaluation($asesi_id)
    {
        $asesi = User::where('user_id', $asesi_id)->first();

        $penilai = Auth::user();
        $currentMonth = Carbon::now()->startOfMonth();

        $evaluation = Evaluation::where('asesi_ternilai_id', $asesi->user_id)
            ->where('penilai_id', $penilai->user_id)
            ->where('bulan_penilaian', $currentMonth)
            ->first();

        if (!$evaluation) {
            return response()->json(['error' => 'Evaluation not found'], 404);
        }

        // Fetch penilaian details for display
        $penilaianDetails = collect($evaluation->detail_penilaian)->map(function ($detail) {
            $penilaian = Penilaian::find($detail['penilaian_id']);
            return [
                'penilaian' => $penilaian ? $penilaian->penilaian : 'Unknown',
                'bobot' => $penilaian ? $penilaian->bobot : 0,
                'score' => $detail['hasil']
            ];
        });

        return response()->json([
            'asesi_name' => $asesi->firstname,
            'month' => $currentMonth->format('F Y'),
            'total_score' => $evaluation->total_akhir,
            'details' => $penilaianDetails
        ]);
    }

    public function exportPdf($asesi_id)
    {
        $asesi = User::where('user_id', $asesi_id)->first();
        $penilai = Auth::user();
        $currentMonth = Carbon::now()->startOfMonth();

        $evaluation = Evaluation::where('asesi_ternilai_id', $asesi->user_id)
            ->where('penilai_id', $penilai->user_id)
            ->where('bulan_penilaian', $currentMonth)
            ->first();

        if (!$evaluation) {
            return redirect()->route('evaluations.index')
                ->with('error', 'Evaluation not found for PDF export');
        }

        // Fetch group name for division
        $group = \App\Models\Group::where('group_id', $asesi->group_id)->first();
        $group_name = $group ? $group->group_name : 'N/A';

        // Fetch penilaian details for PDF
        $penilaianDetails = collect($evaluation->detail_penilaian)->map(function ($detail) {
            $penilaian = Penilaian::find($detail['penilaian_id']);
            return [
                'penilaian' => $penilaian ? $penilaian->penilaian : 'Unknown',
                'bobot' => $penilaian ? $penilaian->bobot : 0,
                'score' => $detail['hasil']
            ];
        });

        $data = [
            'asesi_name' => $asesi->firstname,
            'month' => $currentMonth->format('F Y'),
            'total_score' => $evaluation->total_akhir,
            'details' => $penilaianDetails,
            'group_name' => $group_name,
            'logo_path' => public_path('assets/img/cubiconia.png'),
            'company_name' => 'PT. CUBICONIA KANAYA PRATAMA',
            'address' => 'Signature Park Grande CTB/L1/03, MT Haryono St No.Kav. 20, Cawang, Jakarta 16360',
            'phone' => 'Phone: 0822-2118-8192',
            'email' => 'Email: hello@cubiconia.com',
            'title' => 'LEMBAR HASIL EVALUASI KINERJA KARYAWAN'
        ];

        $pdf = Pdf::loadView('evaluations.pdf', $data);
        return $pdf->download('Evaluation_' . $asesi->firstname . '_' . $currentMonth->format('Y_m') . '.pdf');
    }
}
