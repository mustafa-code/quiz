<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function home()
    {
        return to_route('dashboard');
    }

    public function dashboard()
    {
        $quizzes = Quiz::with('subscribers')->paginate(10);
        return view('tenant.dashboard', compact('quizzes'));
    }

}
