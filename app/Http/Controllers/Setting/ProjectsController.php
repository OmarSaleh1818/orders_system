<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\MultiSections;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{

    public function ProjectView() {

        return view('project.project_view');
    }

    public function AddProject() {

        $user_id = Auth::user()->id;
        $sections = MultiSections::where('user_id', $user_id)->get();
        return view('project.add_project', compact('sections'));
    }



}
