<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function index()
    {
        return view("lowongan.index");
    }

    public function detail()
    {
        return view("lowongan.detail");
    }
}
