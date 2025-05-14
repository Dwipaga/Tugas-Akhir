<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class PublicJobVacancyController extends Controller
{
    public function index()
    {
        // Ambil hanya job vacancy yang active dan belum expired
        $jobVacancies = JobVacancy::active()
                                  ->orderBy('created_at', 'desc')
                                  ->get();
        
        return view('lowongan.index', compact('jobVacancies'));
    }

    public function show($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        
        // Cek apakah masih active dan belum expired
        if (!$jobVacancy->is_active || $jobVacancy->isExpired()) {
            return redirect()->route('public.job-vacancy.index')
                           ->with('error', 'Lowongan kerja tidak tersedia.');
        }
        
        return view('lowongan.detail', compact('jobVacancy'));
    }
}