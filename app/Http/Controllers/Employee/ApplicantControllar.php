<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicantControllar extends Controller
{

    public function applicantView() {

        return view('applicant.applicant_view');
    }

    public function AddOrder() {

        return view('applicant.add_order');
    }


}
