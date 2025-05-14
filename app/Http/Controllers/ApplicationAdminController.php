<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            $query->where(function($q) use ($search) {
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
        $application = Application::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected'
        ]);
        
        $application->update($validated);
        
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