<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public function index()
    {
        $jobVacancies = JobVacancy::all();
        return view('job-vacancy.index', compact('jobVacancies'));
    }

    public function create()
    {
        return view('job-vacancy.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'jenis_pekerjaan' => 'required|in:kontrak,internship,fulltime',
            'deskripsi' => 'required|string',
            'divisi' => 'required|string|max:255',
            'min_pengalaman' => 'required|integer|min:0',
            'ditutup_pada' => 'required|date|after_or_equal:today',
            'is_active' => 'boolean',
            'deskripsi_pekerjaan' => 'required|string',
            'contact_person' => 'required|string|max:255'
        ]);

        JobVacancy::create($validated);

        return redirect()->route('job-vacancy.index')
            ->with('success', 'Job Vacancy berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job-vacancy.form', compact('jobVacancy'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'jenis_pekerjaan' => 'required|in:kontrak,internship,fulltime',
            'deskripsi' => 'required|string',
            'divisi' => 'required|string|max:255',
            'min_pengalaman' => 'required|integer|min:0',
            'ditutup_pada' => 'required|date',
            'is_active' => 'boolean',
            'deskripsi_pekerjaan' => 'required|string',
            'contact_person' => 'required|string|max:255'
        ]);

        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->update($validated);

        return redirect()->route('job-vacancy.index')
            ->with('success', 'Job Vacancy berhasil diupdate.');
    }

    public function destroy($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        return redirect()->route('job-vacancy.index')
            ->with('success', 'Job Vacancy berhasil dihapus.');
    }

    public function show($id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job-vacancy.show', compact('jobVacancy'));
    }
}