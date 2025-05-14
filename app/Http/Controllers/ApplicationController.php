<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function create($jobVacancyId)
    {
        $jobVacancy = JobVacancy::findOrFail($jobVacancyId);
        
        // Cek apakah lowongan masih aktif
        if (!$jobVacancy->is_active || $jobVacancy->isExpired()) {
            return redirect()->route('lowongan.index')
                           ->with('error', 'Lowongan kerja sudah ditutup.');
        }
        
        return view('application.application-form', compact('jobVacancy'));
    }

    public function store(Request $request, $jobVacancyId)
    {
        $jobVacancy = JobVacancy::findOrFail($jobVacancyId);
        
        // Cek apakah lowongan masih aktif
        if (!$jobVacancy->is_active || $jobVacancy->isExpired()) {
            return redirect()->route('lowongan.index')
                           ->with('error', 'Lowongan kerja sudah ditutup.');
        }
        
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date|before:today',
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
            'portfolio_file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240', // Max 10MB
            'linkedin' => 'nullable|url|max:255'
        ]);
        
        // Check if email already applied for this job
        $existingApplication = Application::where('job_vacancy_id', $jobVacancyId)
                                         ->where('email', $validated['email'])
                                         ->exists();
        
        if ($existingApplication) {
            return back()->with('error', 'Anda sudah melamar untuk posisi ini sebelumnya.');
        }
        
        // Upload files
        $cvPath = $request->file('cv_file')->store('applications/cv', 'public');
        $portfolioPath = null;
        
        if ($request->hasFile('portfolio_file')) {
            $portfolioPath = $request->file('portfolio_file')->store('applications/portfolio', 'public');
        }
        
        // Create application
        Application::create([
            'job_vacancy_id' => $jobVacancyId,
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'cv_file' => $cvPath,
            'portfolio_file' => $portfolioPath,
            'linkedin' => $validated['linkedin'],
            'status' => 'pending'
        ]);
        
        return redirect()->route('lowongan.show', $jobVacancyId)
                        ->with('success', 'Lamaran Anda berhasil dikirim. Kami akan menghubungi Anda segera.');
    }
}