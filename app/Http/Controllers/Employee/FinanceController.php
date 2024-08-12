<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Finance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FinanceController extends Controller
{
//    function __construct()
//    {
//
//        $this->middleware('permission:المحاسب', ['only' => ['FinanceView']]);
//        $this->middleware('permission:منفذ الطلب', ['only' => ['FinanceEye']]);
//
//    }
    public function FinanceView() {

        $applicants = Applicant::orderBy('id','DESC')->orderBy('status_id', 'ASC')->get();
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
        $originalFile = $file->getClientOriginalName();
        $sanitizedFile = Str::slug(pathinfo($originalFile, PATHINFO_FILENAME), '_') . '.' . $file->getClientOriginalExtension();
        $filePath = $file->move("upload", $sanitizedFile);
        
        if($filePath) {
            Finance::insert([
                'applicant_id' => $id,
                'attachment' => $filePath,
                'created_at' => now(),
            ]);
            DB::table('applicants')
                ->where('id', $id)
                ->update(['status_id' => 5, 'value' => $value]);

            DB::table('projects')
                ->where('id', $request->project_id)
                ->decrement('remaining_value', $request->price);


            Session()->flash('status', 'تم تنفيذ الطلب بنجاح');
            return redirect('/applicant/view');
        } else {
            Session()->flash('status', 'للأسف لم يتم نقل الملف');
            return redirect('/applicant/view');
        }

    }


}
