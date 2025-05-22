<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $penilaians = Penilaian::with(['asesi', 'asesor'])->get();
        return view("penilaian.index", compact('penilaians'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('penilaian.form', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'penilaian' => 'required|string|max:255',
            'asesi_id' => 'required|exists:groups,group_id',
            'asesor_id' => 'required|exists:groups,group_id',
            'bobot' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean'
        ]);
        $validated['is_active'] = isset($validated['is_active']) && $validated['is_active'] == 1 ? 1 : 0;
        Penilaian::create($validated);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $groups = Group::all();
        return view('penilaian.form', compact('penilaian', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'penilaian' => 'required|string|max:255',
            'asesi_id' => 'required|exists:groups,group_id',
            'asesor_id' => 'required|exists:groups,group_id',
            'bobot' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean'
        ]);
        $validated['is_active'] = isset($validated['is_active']) && $validated['is_active'] == 1 ? 1 : 0;

        $penilaian = Penilaian::findOrFail($id);
        $penilaian->update($validated);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil diupdate.');
    }

    public function destroy($id)
    {
        $penilaian = Penilaian::findOrFail($id);
        $penilaian->delete();

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}
