<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\EmployeeContract;
use Barryvdh\DomPDF\Facade\Pdf;


class EmployeeDataController extends Controller
{
    public function create()
    {
        $role = DB::table('applications')
            ->join('job_vacancies', 'applications.job_vacancy_id', '=', 'job_vacancies.id')
            ->select('job_vacancies.nama_pekerjaan')
            ->where('applications.email', Auth::user()->email)
            ->first();

        $user = Auth::user();
        $contract = EmployeeContract::where('user_id', $user->user_id)->first();

        return view('employee-data.form', compact('role', 'user', 'contract'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'scan_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'scan_npwp' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'npwp' => 'nullable|string|max:15',
            'nama_bank' => 'required|string',
            'nomor_rekening' => 'required|string'
        ]);

        $user = Auth::user();

        if ($request->hasFile('scan_ktp')) {
            $fileName = 'ktp_' . $user->user_id . '_' . time() . '.' . $request->file('scan_ktp')->getClientOriginalExtension();
            $ktpPath = $request->file('scan_ktp')->storeAs('documents/ktp', $fileName, 'public');
            $user->scan_ktp = $ktpPath;
        }

        if ($request->hasFile('scan_npwp')) {
            $fileName = 'npwp_' . $user->user_id . '_' . time() . '.' . $request->file('scan_npwp')->getClientOriginalExtension();
            $npwpPath = $request->file('scan_npwp')->storeAs('documents/npwp', $fileName, 'public');
            $user->scan_npwp = $npwpPath;
        }

        $user->npwp = $request->npwp;
        $user->nama_bank = $request->nama_bank;
        $user->nomor_rekening = $request->nomor_rekening;
        $user->save();

        $this->generateContract($user);

        return redirect()->route('employee-data.create')
            ->with('success', 'Data berhasil disimpan dan kontrak sedang digenerate!');
    }

    public function uploadSignedContract(Request $request)
    {
        $request->validate([
            'signed_contract' => 'required|file|mimes:pdf',
        ]);

        $user = Auth::user();
        $contract = EmployeeContract::where('user_id', $user->user_id)->first();

        if (!$contract) {
            return redirect()->route('employee-data.create')
                ->with('error', 'Kontrak tidak ditemukan. Silakan generate kontrak terlebih dahulu.');
        }

        if ($request->hasFile('signed_contract')) {
            $fileName = 'signed_contract_' . $user->user_id . '_' . time() . '.pdf';
            $signedContractPath = $request->file('signed_contract')->storeAs('documents/signed_contracts', $fileName, 'public');
            $user->dokumen_kontrak = $signedContractPath;
            $user->save();

            $contract->status = 'signed';
            $contract->save();

            return redirect()->route('employee-data.create')
                ->with('success', 'Dokumen kontrak yang ditandatangani berhasil diunggah!');
        }

        return redirect()->route('employee-data.create')
            ->with('error', 'Gagal mengunggah dokumen kontrak.');
    }

    private function generateContract($user)
    {
        $application = DB::table('applications')
            ->join('job_vacancies', 'applications.job_vacancy_id', '=', 'job_vacancies.id')
            ->select('job_vacancies.nama_pekerjaan', 'applications.*')
            ->where('applications.email', $user->email)
            ->first();

        $contractData = [
            'user_id' => $user->user_id,
            'nama_karyawan' => $user->firstname . ' ' . $user->lastname,
            'tanggal_lahir' => $user->tanggal_lahir ?? '-',
            'alamat' => $user->alamat ?? '-',
            'jabatan' => $application->nama_pekerjaan ?? '-',
            'nama_bank' => $user->nama_bank,
            'nomor_rekening' => $user->nomor_rekening,
            'nama_acc' =>  $user->firstname . ' ' . $user->lastname,
            'tanggal_kontrak' => now()->format('d-m-Y'),
            'tanggal_mulai' => now()->format('d-m-Y'),
            'tanggal_berakhir' => now()->addMonths(6)->format('d-m-Y'),
            'durasi' => '6 bulan',
            'tim_penempatan' => 'Development Team',
            'kompensasi' => 'Rp 2.000.000,-',
            'logo_path' => public_path('assets/img/cubiconia.png'),
            'company_name' => 'PT. Cubiconia Kanaya Pratama',
            'company_address' => 'Signature Park Grande CTB/L1/03, MT Haryono St No.Kav. 20, Cawang, Jakarta 16360',
            'company_phone' => 'Phone: 0822-2118-8192',
            'company_email' => 'Email: hello@cubiconia.com',
        ];

        $contractPath = $this->createContractDocument($contractData);

        EmployeeContract::create([
            'user_id' => $user->user_id,
            'contract_data' => $contractData,
            'contract_path' => $contractPath,
            'generated_at' => now(),
            'status' => 'generated'
        ]);
    }

    private function createContractDocument($data)
    {
        try {
            $contractPath = 'contracts/contract_' . $data['user_id'] . '.pdf';
            \Log::info('Saving contract to: ' . storage_path('app/public/' . $contractPath));
            Storage::disk('public')->makeDirectory('contracts');

            $pdf = Pdf::loadView('templates.contract_template', $data);
            Storage::disk('public')->put($contractPath, $pdf->output());

            if (!Storage::disk('public')->exists($contractPath)) {
                throw new \Exception('Failed to save contract PDF');
            }
            return $contractPath;
        } catch (\Exception $e) {
            \Log::error('Contract generation failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e; // Rethrow for debugging
        }
    }
    public function viewContract($userId)
    {
        $contract = EmployeeContract::where('user_id', $userId)->first();

        if (!$contract || !Storage::disk('public')->exists($contract->contract_path)) {
            return redirect()->route('employee-data.create')
                ->with('error', 'Kontrak tidak ditemukan atau belum digenerate.');
        }

        $filePath = storage_path('app/public/' . $contract->contract_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($contract->contract_path) . '"'
        ]);
    }

    public function downloadContract($userId)
    {
        $contract = EmployeeContract::where('user_id', $userId)->first();

        if (!$contract || !Storage::disk('public')->exists($contract->contract_path)) {
            return redirect()->route('employee-data.create')
                ->with('error', 'Kontrak tidak ditemukan atau belum digenerate.');
        }

        $filePath = storage_path('app/public/' . $contract->contract_path);
        return response()->download($filePath, 'Contract_' . $contract->user_id . '.pdf');
    }
}
