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
        return redirect('/finance/manager/view');
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
        return redirect('/finance/manager/view');
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
            ->update(['status_id' => 12]);
        Session()->flash('status', 'لم يتم اعتماد الطلب بنجاح');
        return redirect('/finance/manager/view');
    }

    public function FinanceManagerSure($id) {
        DB::table('applicants')
            ->where('id', $id)
            ->update(['status_id' => 4]);
        Session()->flash('status', 'تم اعتماد الصرف بنجاح');
        return redirect('/finance/manager/view');
    }


}
