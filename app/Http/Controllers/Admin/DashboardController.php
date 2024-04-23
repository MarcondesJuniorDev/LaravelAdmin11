<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public readonly User $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function index(): View
    {
        $countUsers = $this->user->count();
        return view('admin.dashboard', compact('countUsers'));
    }
}
