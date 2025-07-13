<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::join('groups', 'users.group_id', '=', 'groups.group_id')->where('users.group_id', '!=', '7')->paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $groups = DB::table('groups')->get();
$labels = [];
        $data = [];
        return view('user.form', ['groups' => $groups, 'user' => null, 'labels' => $labels, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|max:50|unique:users',
            'tanggal_lahir' => 'nullable|date', // Added for date of birth
            'tanggal_masuk' => 'nullable|date', // Added for date of joining
            'tanggal_akhir_kontrak' => 'nullable|date', // Added for contract
            'npwp' => 'required|string|max:20|unique:users', // Added for NPWP
            'jenis_kontrak' => 'nullable|string|max:50', // Added for contract
            'dokumen_kontrak' => 'nullable|string|max:100', // Added for contract document
            'group_id' => 'required',
            'nik' => 'required',
            'divisi' => 'required',
            'alamat' => 'required',
            'tempat_lahir' => 'required',
            'email' => 'required|email|unique:users',
            'firstname' => 'required|string|max:100', // Changed from first_name to match form
            'lastname' => 'required|string|max:100',  // Changed from last_name to match form
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $validated = $validated->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $originalName = Auth::user()->user_id;
            $extension = $file->getClientOriginalExtension();
            Storage::disk('public')->put('user-photos/' . $originalName . '.' . $extension, file_get_contents($file));
            $validated['photo'] = $originalName . '.' . $extension;
        }

        if ($request->hasFile('dokumen_kontrak')) {

            $file = $request->file('dokumen_kontrak');
            $originalName = Auth::user()->user_id;
            $extension = $file->getClientOriginalExtension();
            Storage::disk('public')->put('dokumen-files/' . $originalName . '.' . $extension, file_get_contents($file));
            $validated['dokumen_kontrak'] = $originalName . '.' . $extension;
        }

        // Hash password
        $validated['password'] = $request->password;

        // Map form field names to database columns if needed
        $userData = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'group_id' => $validated['group_id'],
            'firstname' => $validated['firstname'], // Map to database column
            'lastname' => $validated['lastname'],   // Map to database column
            'phone' => $validated['phone'],
            'password' => md5($validated['password']),
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null, // Added for date of birth
            'tanggal_masuk' => $validated['tanggal_masuk'] ?? null, // Added for date of joining
            'tanggal_akhir_kontrak' => $validated['tanggal_akhir_kontrak'] ?? null, // Added for contract
            'npwp' => $validated['npwp'], // Added for NPWP
            'nik' => $validated['nik'], // Added for NPWP
            'alamat' => $validated['alamat'], // Added for NPWP
            'divisi' => $validated['divisi'], // Added for NPWP
            'tempat_lahir' => $validated['tempat_lahir'], // Added for NPWP
            'jenis_kontrak' => $validated['jenis_kontrak'] ?? null, // Added for contract
            'dokumen_kontrak' => $validated['dokumen_kontrak'] ?? null, // Added for contract document
        ];

        if (isset($validated['photo'])) {
            $userData['photo'] = $validated['photo'];
        }

        $user = User::create($userData);
        $divisi = $user->divisi;
        if ($divisi == 'PROGRAMMER') {
            $divisi = 'PRG';
        } else if ($divisi == 'CONSULTANT') {
            $divisi = 'CST';
        };
        $id_karyawan = 'CBC-' . $divisi . '-' . date('Ymd') . '-' . str_pad($user->user_id, 4, '0', STR_PAD_LEFT);
        $user->update(['id_karyawan' => $id_karyawan]); // Update the user with the generated NIK 

        return redirect()->route('user.index')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $groups = DB::table('groups')->get();
        $user = User::findOrFail($id);

        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();

        $evaluations = DB::table('evaluations')
            ->selectRaw('MONTH(bulan_penilaian) as bulan, YEAR(bulan_penilaian) as tahun, total_akhir')
            ->where('asesi_ternilai_id', $user->user_id)
            ->where('bulan_penilaian', '>=', $sixMonthsAgo)
            ->orderBy('bulan_penilaian')
            ->get();

        $labels = [];
        $data = [];

        foreach ($evaluations as $e) {
            $labels[] = Carbon::create($e->tahun, $e->bulan)->translatedFormat('F Y');
            $data[] = $e->total_akhir;
        }

        return view('user.form', compact('user', 'groups', 'labels', 'data'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username' => "required|string|max:50|unique:users,username,{$id},user_id",
            'email' => "required|email|unique:users,email,{$id},user_id",
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'group_id' => 'required',
            'divisi' => 'required',
            'nik' => 'required',
            'alamat' => 'required',
            'npwp' => "nullable|string|max:20|unique:users,npwp,{$id},user_id",
            'tanggal_lahir' => 'nullable|date',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_akhir_kontrak' => 'nullable|date',
            'jenis_kontrak' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'dokumen_kontrak' => 'nullable|file|max:5120',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->fill($validated);

        if ($request->hasFile('photo')) {
            if ($user->photo) Storage::disk('public')->delete('user-photos/' . $user->photo);
            $photoName = $user->user_id . '.' . $request->photo->extension();
            $request->photo->storeAs('user-photos', $photoName, 'public');
            $user->photo = $photoName;
        }

        if ($request->hasFile('dokumen_kontrak')) {
            if ($user->dokumen_kontrak) Storage::disk('public')->delete('dokumen-files/' . $user->dokumen_kontrak);
            $fileName = $user->user_id . '.' . $request->dokumen_kontrak->extension();
            $request->dokumen_kontrak->storeAs('dokumen-files', $fileName, 'public');
            $user->dokumen_kontrak = $fileName;
        }

        if ($request->filled('password')) {
            $user->password = md5($request->password);
        } else {
            unset($user->password); // Do not update password if not provided
        }

        $user->update();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Delete photo if exists
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User deleted successfully.');
    }
}
