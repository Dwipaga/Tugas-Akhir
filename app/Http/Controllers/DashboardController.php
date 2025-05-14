<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $generalService;
    

    
    public function index()
    {
        $notifications = [];
        
        $messages = [];
        
        return view('dashboard.index', compact('notifications', 'messages'));
    }
}