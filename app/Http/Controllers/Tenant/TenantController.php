<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function home()
    {
        return to_route('dashboard');
    }

    public function dashboard()
    {
        return view('tenant.dashboard');
    }

}
