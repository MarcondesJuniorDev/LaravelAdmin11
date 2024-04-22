<?php

namespace App\Http\Controllers\Admin\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function index(): View
    {
        return view('admin.acl.permissions.index');
    }
}
