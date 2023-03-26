<?php

namespace App\Domains\Panel\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class TenantController extends Controller
{
    public function index(): View
    {
        return view('tenant.list');
    }
}
