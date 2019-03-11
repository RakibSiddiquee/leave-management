<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Leave;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalEmployee = Employee::where('status', 1)->count();
        $totalLeave = Leave::count();
        $totalAdmin = User::where('status', 1)->count();
        return view('dashboard', compact('totalEmployee', 'totalLeave', 'totalAdmin'));
    }
}
