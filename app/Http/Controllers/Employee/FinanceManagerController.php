<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\MultiSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceManagerController extends Controller
{

    public function FinanceManagerView() {

        $user_id = Auth::user()->id;
        $applicants = Applicant::where('user_id', $user_id)->get();
        return view('financeManager.finance_manager_view', compact('applicants'));
    }

    public function FinanceManagerEye($id) {
        $user_id = Auth::user()->id;

        $sections = MultiSections::where('user_id', $user_id)->get();
        $applicant = Applicant::find($id);
        return view('financeManager.finance_manager_eye', compact('sections', 'applicant'));
    }



}
