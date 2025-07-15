<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $generalService;
    

    
    public function index()
    {
        $users = User::where('group_id', '!=', 7)->count();
        
        $jobs = Application::where('status', 'pending')->count();
        
        return view('dashboard.index', compact('users', 'jobs'));
    }
}