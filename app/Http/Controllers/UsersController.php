<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('user-photos', 'public');
        }

        // Hash password
        $validated['password'] = bcrypt($request->password);

        User::create($validated);

        return redirect()->route('user.index')
               ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('user.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|max:50|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('user-photos', 'public');
        }

        // Update password if provided
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('user.index')
               ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Delete photo if exists
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('user.index')
               ->with('success', 'User deleted successfully.');
    }
}