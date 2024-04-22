<?php

namespace App\Http\Controllers\Admin\LMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        return view('admin.lms.course.index');
    }
}
