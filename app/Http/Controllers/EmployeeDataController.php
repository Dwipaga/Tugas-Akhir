<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeDataController extends Controller
{
    public function create()
    {
        $role = DB::table('applications')
            ->join('job_vacancies', 'applications.job_vacancy_id', '=', 'job_vacancies.id')
            ->select('job_vacancies.nama_pekerjaan')
            ->where('applications.email', Auth::user()->email)
            ->first();
        $user = Auth::user()->scan_ktp;

        return view('employee-data.form', compact('role', 'user'));
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'npwp' => 'nullable|digits:15',
            'nama_bank' => 'required|string',
            'nomor_rekening' => 'required_if:nama_bank,!=,null',
            'scan_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'scan_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'dokumen_kontrak' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);
        if ($validated->fails()) {
            
            return redirect()->back()
                ->with('error', json_encode($validated->errors()));
        }

        $user = Auth::user();

        if ($request->hasFile('scan_ktp')) {
            $user->scan_ktp = $request->file('scan_ktp')->store('documents');
        }

        if ($request->hasFile('scan_npwp')) {
            $user->scan_npwp = $request->file('scan_npwp')->store('documents');
        }

        if ($request->hasFile('dokumen_kontrak')) {
            $user->dokumen_kontrak = $request->file('dokumen_kontrak')->store('documents');
        }

        $user->npwp = $request->npwp;
        $user->nama_bank = $request->nama_bank;
        $user->nomor_rekening = $request->nomor_rekening;
        $user->save();

        return redirect()->route('employee-data.create')->with('success', 'Data berhasil disimpan.');
    }
}
?>