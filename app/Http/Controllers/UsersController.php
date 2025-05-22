<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::join('groups', 'users.group_id', '=', 'groups.group_id')->paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $groups = DB::table('groups')->get();

        return view('user.form', ['groups' =>$groups, 'user' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|max:50|unique:users',
            'group_id' => 'required',
            'email' => 'required|email|unique:users',
            'firstname' => 'required|string|max:100', // Changed from first_name to match form
            'lastname' => 'required|string|max:100',  // Changed from last_name to match form
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            
            $file = $request->file('photo');
            $originalName = Auth::user()->user_id;
            $extension = $file->getClientOriginalExtension();
            Storage::disk('public')->put('user-photos/' . $originalName . '.' . $extension, file_get_contents($file));
            $validated['photo'] = $originalName . '.' . $extension;
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
        ];
        
        if (isset($validated['photo'])) {
            $userData['photo'] = $validated['photo'];
        }

        User::create($userData);

        return redirect()->route('user.index')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $groups = DB::table('groups')->get();
        $user = User::findOrFail($id);
        return view('user.form', compact('user', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validate the request
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|max:50|unique:users,username,'.$id.',user_id', // Fixed unique rule
            'email' => 'required|email|unique:users,email,'.$id.',user_id', // Fixed unique rule
            'firstname' => 'required|string|max:100', // Changed to match form field
            'lastname' => 'required|string|max:100',  // Changed to match form field
            'phone' => 'required|string|max:20',
            'group_id' => 'required',
            'password' => 'nullable|string|min:8' // Removed confirmed validation for updates
        ]);

        // Map form field names to database columns
        $userData = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'group_id' => $validated['group_id'],
            'first_name' => $validated['firstname'], // Map to database column
            'last_name' => $validated['lastname'],   // Map to database column
            'phone' => $validated['phone'],
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $file = $request->file('photo');
            $originalName = Auth::user()->user_id;
            $extension = $file->getClientOriginalExtension();
            Storage::disk('public')->put('user-photos/' . $originalName . '.' . $extension, file_get_contents($file));
            $userData['photo'] = $originalName . '.' . $extension;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password); // Use bcrypt instead of md5
        }

        // Update the user
        $user->update($userData);

        return redirect()->route('user.index')
            ->with('success', 'User updated successfully.');
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