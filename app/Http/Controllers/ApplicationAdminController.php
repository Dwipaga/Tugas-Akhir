<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountAcceptedMail;


class ApplicationAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with(['jobVacancy'])
            ->orderBy('created_at', 'desc');

        // Filter by job vacancy
        if ($request->filled('job_vacancy_id')) {
            $query->where('job_vacancy_id', $request->job_vacancy_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $applications = $query->paginate(20)->withQueryString();
        $jobVacancies = JobVacancy::orderBy('nama_pekerjaan')->get();

        return view('apps.index', compact('applications', 'jobVacancies'));
    }

    public function show($id)
    {
        $application = Application::with('jobVacancy')->findOrFail($id);
        return view('apps.show', compact('application'));
    }

    public function updateStatus(Request $request, $id)
    {
        $application = Application::join('job_vacancies', 'applications.job_vacancy_id', 'job_vacancies.id')->where('applications.id', $id);

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected'
        ]);

        $application->update(['status' => $validated['status']]);
        $application = Application::join('job_vacancies', 'applications.job_vacancy_id', 'job_vacancies.id')->where('applications.id', $id);
        $application = $application->first();

        // Jika status diterima, buat akun dan kirim email
        if ($validated['status'] === 'accepted') {
            // Cek apakah user dengan email sudah ada
            $existingUser = \App\Models\User::where('email', $application->email)->first();

            if (!$existingUser) {
                $randomPassword = Str::random(10);
                $divisi = $application->divisi;
                if ($divisi == 'PROGRAMMER') {
                    $divisi = 'PRG';
                } else if ($divisi == 'CONSULTANT') {
                    $divisi = 'CST';
                };

                $id_karyawan = 'CBC-' . $divisi . '-' . date('Ymd') . '-' . rand(1000, 9999);
                $user = \App\Models\User::create([
                    'email' => $application->email,
                    'id_karyawan' => $id_karyawan,
                    'password' => md5($randomPassword),
                    'firstname' => $application->firstname,
                    'lastname' => $application->lastname,
                    'phone' => $application->phone,
                    'dokumen' => $application->cv_file,
                    'divisi' => $application->divisi,
                    'alamat' => '-',
                    'tempat_lahir' => '-',
                    'group_id' => 7,
                ]);

                // Kirim email
                Mail::to($application->email)->send(new \App\Mail\AccountAcceptedMail(
                    $application->firstname,
                    $application->lastname,
                    $application->jobVacancy->nama_pekerjaan,
                    $application->email,
                    $randomPassword
                ));
            }
        }

        if ($validated['status'] === 'rejected') {
            Mail::to($application->email)->send(new \App\Mail\ApplicationRejectedMail(
                $application->firstname,
                $application->lastname,
                $application->jobVacancy->nama_pekerjaan
            ));
        }

        return redirect()->route('admin.applications.index')
            ->with('success', 'Status lamaran berhasil diupdate.');
    }


    public function downloadCV($id)
    {
        $application = Application::findOrFail($id);
        return response()->download(storage_path('app/public/' . $application->cv_file));
    }

    public function downloadPortfolio($id)
    {
        $application = Application::findOrFail($id);

        if (!$application->portfolio_file) {
            return redirect()->back()->with('error', 'Portfolio tidak tersedia.');
        }

        return response()->download(storage_path('app/public/' . $application->portfolio_file));
    }
}
