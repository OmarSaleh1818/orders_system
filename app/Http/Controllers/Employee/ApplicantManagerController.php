<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantManager;
use App\Models\MultiSections;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicantManagerController extends Controller
{

    public function applicantManagerView() {

        $user_id = Auth::user()->id;
        $applicants = Applicant::where('user_id', $user_id)->get();
        return view('applicantManager.applicant_manager_view', compact('applicants'));
    }

    public function ApplicantManagerEye($id) {

        $user_id = Auth::user()->id;

        $sections = MultiSections::where('user_id', $user_id)->get();
        $applicant = Applicant::find($id);
        return view('applicantManager.applicant_manager_eye', compact('sections', 'applicant'));
    }

    public function ApplicantManagerSure($id) {
        DB::table('applicants')
            ->where('id', $id)
            ->update(['status_id' => 3]);
        Session()->flash('status', 'تم اعتماد الطلب بنجاح');
        return redirect('/applicant/manager/view');
    }

    public function ApplicantManagerReject(Request $request, $id) {

        $request->validate([
            'manager_reason'=> 'required'
        ],[
           'manager_reason.required' => 'السبب مطلوب'
        ]);
        $existingRecord = ApplicantManager::where('applicant_id', $id)->first();
        if ($existingRecord) {
            $existingRecord->update([
                'manager_reason' => $request->manager_reason,
                'created_at' => Carbon::now(),
            ]);
        } else {
            ApplicantManager::insert([
                'applicant_id' => $id,
                'manager_reason' => $request->manager_reason,
                'created_at' => Carbon::now(),
            ]);
        }
        DB::table('applicants')
            ->where('id', $id)
            ->update(['status_id' => 2]);
        Session()->flash('status', 'لم يتم اعتماد الطلب بنجاح');
        return redirect('/applicant/manager/view');
    }

    public function ApplicantManagerBack() {
        return redirect('/applicant/manager/view');
    }


}