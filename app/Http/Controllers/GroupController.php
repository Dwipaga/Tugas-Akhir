<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view('group.index', compact('groups'));
    }

    public function create()
    {
        return view('group.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_name' => 'required|string|max:50',
            'group_desc' => 'nullable|string|max:255',
            'status' => 'nullable|in:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Group::create([
            'group_name' => $request->group_name,
            'group_desc' => $request->group_desc,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

    public function edit(Group $group)
    {
        return view('group.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $validator = Validator::make($request->all(), [
            'group_name' => 'required|string|max:50',
            'group_desc' => 'nullable|string|max:255',
            'status' => 'nullable|in:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $group->update([
            'group_name' => $request->group_name,
            'group_desc' => $request->group_desc,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
    }
}