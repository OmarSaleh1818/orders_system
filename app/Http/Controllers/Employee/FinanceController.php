<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Finance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{

    public function FinanceView() {

        $user_id = Auth::user()->id;
        $applicants = Applicant::where('user_id', $user_id)->orderBy('id','DESC')->orderBy('status_id', 'ASC')->get();
        return view('finance.finance_view', compact('applicants'));
    }

    public function FinanceEye($id) {

        $applicant = Applicant::find($id);
        return view('finance.finance_eye', compact('applicant'));
    }

    public function FinanceBack() {
        return redirect('/finance/view');
    }

    public function FinanceAttachment(Request $request, $id) {

        $request->validate([
            'attachment' => 'required|mimes:pdf,doc,docx',
        ], [
            'attachment.required' => 'إرفاق الملف مطلوب',
            'attachment.mimes' => 'يجب أن يكون الملف من نوع PDF أو DOC',
        ]);
        $value = $request->value - $request->price;
        $file = $request->file('attachment');
        $filePath = $file->move("upload", $file->getClientOriginalName());
        if($filePath) {
            Finance::insert([
                'applicant_id' => $id,
                'attachment' => $filePath,
                'created_at' => now(),
            ]);
            DB::table('applicants')
                ->where('id', $id)
                ->update(['status_id' => 5, 'value' => $value]);

            Session()->flash('status', 'تم تنفيذ الطلب بنجاح');
            return redirect('/finance/view');
        } else {
            Session()->flash('status', 'لم يتم نقل الملف بنجاح');
            return redirect('/finance/view');
        }

    }


}
