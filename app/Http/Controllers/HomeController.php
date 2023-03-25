<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Octane\Facades\Octane;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
