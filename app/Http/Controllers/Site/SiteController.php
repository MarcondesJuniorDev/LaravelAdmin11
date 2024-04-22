<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('site.principal.home');
    }

    public function aboutHistory(): View
    {
        return view('site.about.history');
    }

    public function aboutOrgChart(): View
    {
        return view('site.about.orgchart');
    }

    public function aboutProjects(): View
    {
        return view('site.about.projects');
    }

    public function aboutPartners(): View
    {
        return view('site.about.partners');
    }

    public function elementarySchool(): View
    {
        return view('site.lessons.elementary');
    }

    public function highSchool(): View
    {
        return view('site.lessons.highschool');
    }

    public function adultElementaryEducation(): View
    {
        return view('site.lessons.adult.elementary');
    }

    public function adultHighEducation(): View
    {
        return view('site.lessons.adult.highschool');
    }

    public function stayinEvents(): View
    {
        return view('site.stayin.events');
    }

    public function stayinNews(): View
    {
        return view('site.stayin.news');
    }

    public function stayinPublications(): View
    {
        return view('site.stayin.publications');
    }

    public function awards(): View
    {
        return view('site.awards.awards');
    }

    public function contact(): View
    {
        return view('site.contact.contactus');
    }
}
