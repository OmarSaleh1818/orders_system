<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{

    public function FinanceView() {

        $user_id = Auth::user()->id;
        $applicants = Applicant::where('user_id', $user_id)->get();
        return view('finance.finance_view', compact('applicants'));
    }


}
