<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\FinanceManager;
use App\Models\MultiSections;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceManagerController extends Controller
{
//    function __construct()
//    {
//
//        $this->middleware('permission:المدير المالي', ['only' => ['FinanceManagerView']]);
//        $this->middleware('permission:معتمد الصرف', ['only' => ['FinanceManagerEye','FinanceManagerInquiry']]);
//        $this->middleware('permission:معتمد الصرف', ['only' => ['FinanceManagerReject','FinanceManagerSure']]);
//
//    }

    public function FinanceManagerView() {

        $applicants = Applicant::orderBy('id','DESC')->orderBy('status_id', 'ASC')->get();
        return view('financeManager.finance_manager_view', compact('applicants'));
    }

    public function FinanceManagerEye($id) {

        $applicant = Applicant::find($id);
        return view('financeManager.finance_manager_eye', compact( 'applicant'));
    }

    public function FinanceManagerInquiry(Request $request, $id) {
        $request->validate([
            'inquiry'=> 'required'
        ],[
            'inquiry.required' => 'الاستفسار مطلوب'
        ]);
        $existingRecord = FinanceManager::where('applicant_id', $id)->first();
        if ($existingRecord) {
            $existingRecord->update([
                'inquiry' => $request->inquiry,
                'created_at' => Carbon::now(),
            ]);
        } else {
            FinanceManager::insert([
                'applicant_id' => $id,
                'inquiry' => $request->inquiry,
                'created_at' => Carbon::now(),
            ]);
        }
        DB::table('applicants')
            ->where('id', $id)
            ->update(['status_id' => 8]);
        Session()->flash('status', 'تم إرسال الاستفسار بنجاح');
        return redirect('/applicant/view');
    }

    public function FinanceManagerBack() {
        return redirect('/finance/manager/view');
    }

    public function ProposedDate(Request $request, $id) {

        $request->validate([
            'payment_date'=> 'required',
        ],[
            'payment_date.required' => 'التاريخ المقترح مطلوب',

        ]);

        Applicant::findOrFail($id)->update([
            'payment_date' => $request->payment_date,
            'status_id' => 10,
            'created_at' => Carbon::now(),
        ]);

        Session()->flash('status', 'تم  تأجيل التاريخ بنجاح');
        return redirect('/applicant/view');
    }

    public function FinanceManagerReject(Request $request, $id) {
        $request->validate([
            'finance_reason' => 'required'
        ], [
            'finance_reason.required' => 'السبب مطلوب'
        ]);
        $existingRecord = FinanceManager::where('applicant_id', $id)->first();
        if ($existingRecord) {
            $existingRecord->update([
                'finance_reason' => $request->finance_reason,
                'created_at' => Carbon::now(),
            ]);
        } else {
            FinanceManager::insert([
                'applicant_id' => $id,
                'finance_reason' => $request->finance_reason,
                'created_at' => Carbon::now(),
            ]);
        }
        DB::table('applicants')
            ->where('id', $id)
            ->update(['status_id' => 12, 'remaining_value' => $request->value]);

        DB::table('projects')
            ->where('id', $request->project_name)
            ->update(['remaining_value' => $request->value]);

        DB::table('multi_projects')
            ->where('item_name', $request->item_name)
            ->update(['remaining_value' => $request->value]);
        Session()->flash('status', 'لم يتم اعتماد الطلب ');
        return redirect('/applicant/view');
    }

    public function FinanceManagerSure($id) {
        DB::table('applicants')
            ->where('id', $id)
            ->update(['status_id' => 6]);

        Session()->flash('status', 'تم الاعتماد بنجاح');
        return redirect('/applicant/view');
    }

    public function FinanceOrderSure($id) {
        DB::table('applicants')
            ->where('id', $id)
            ->update(['status_id' => 4]);

        Session()->flash('status', 'تم اعتماد الصرف بنجاح');
        return redirect('/applicant/view');

    }


}
