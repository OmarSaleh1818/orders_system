<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\ApplicantManager;
use App\Models\FinanceManager;
use App\Models\MultiProject;
use App\Models\MultiStep;
use App\Models\projects;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MultiSections;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApplicantControllar extends Controller
{
    function __construct()
    {

        $this->middleware('permission:طلبات الصرف', ['only' => ['applicantView', 'applicantEye']]);
        $this->middleware('permission:إضافة طلب صرف', ['only' => ['AddOrder','ApplicantStore']]);
        $this->middleware('permission:تعديل طلب صرف', ['only' => ['ApplicantEdit','ApplicantUpdate']]);
//        $this->middleware('permission:مقدم الطلب', ['only' => ['applicantDelete']]);

    }
    public function applicantView() {

        $applicants = Applicant::orderBy('id','DESC')->orderBy('status_id', 'ASC')->get();

        return view('applicant.applicant_view', compact('applicants'));
    }

    public function AddOrder() {
        $user_id = Auth::user()->id;
        $order_number = Applicant::orderBy('order_number', 'desc')->first();
        if ($order_number) {
            $lastOrderNumber = explode('-', $order_number->order_number);
            $lastThreeNumbers = intval(end($lastOrderNumber));
        } else {
            $lastThreeNumbers = 0;
        }
        $newThreeNumbers = str_pad($lastThreeNumbers + 1, 3, '0', STR_PAD_LEFT);
        $newOrderNumber = $newThreeNumbers;


        $sections = MultiSections::where('user_id', $user_id)->get();
        $projects = projects::where('status_id', 13)->get();
        return view('applicant.add_order', compact('sections', 'projects', 'newOrderNumber'));
    }

    public function ApplicantStore(Request $request) {

        $request->validate([
            'project_id' => 'required',
            'item_name' => 'required',
            'item_value' => 'required',
            'remaining_value' => 'required',
            'date' => 'required',
            'section_name' => 'required',
            'price' => 'required',
            'priority_level' => 'required',
            'account_number' => 'required',
            'bank_name' => 'required',
            'benefit_name' => 'required',
            'payment_date' => 'required',
        ],[
            'project_id.required' => 'اسم المشروع مطلوب',
            'item_name.required' => 'بند الصرف مطلوب',
            'item_value.required' => 'القيمة مطلوب',
            'remaining_value.required' => 'المبلغ المتبقي مطلوب',
            'date.required' => 'التاريخ مطلوب',
            'section_name.required' => 'اسم القسم مطلوب',
            'price.required' => 'المبلغ يجب ان يكون اقل من المبلغ المتبقي',
            'priority_level.required' => 'مستوى الاولوية مطلوب',
            'account_number.required' => 'رقم الحساب مطلوب',
            'bank_name.required' => 'اسم البنك مطلوب',
            'benefit_name.required' => 'اسم صاحب الحساب البنكي مطلوب',
            'payment_date.required' => 'تاريخ استحقاق الدفعة مطلوب',
        ]);
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number='.$request->price;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'authority: ahsibli.com',
                'accept: */*',
                'accept-language: en-US,en;q=0.9,ar;q=0.8',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'cookie: _gid=GA1.2.1200696489.1685273984; _gat_gtag_UA_166450035_1=1; _ga_ZSCB2L9KV5=GS1.1.1685273984.1.0.1685273984.0.0.0; _ga=GA1.1.554570941.1685273984; __gads=ID=5f01af1de5c542fc-22db0e9221e000e8:T=1685273984:RT=1685273984:S=ALNI_MYwwhfNBetLRtXSGsPPMr4LZdkrEA; __gpi=UID=00000c364d77d5ca:T=1685273984:RT=1685273984:S=ALNI_MZ7D_ac8H9HvpAIArSyXiZTznxl0Q',
                'origin: https://ahsibli.com',
                'referer: https://ahsibli.com/tool/number-to-words/',
                'sec-ch-ua: "Chromium";v="113", "Not-A.Brand";v="24"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
                'x-requested-with: XMLHttpRequest'
            )
        );

// Initialize cURL session
        $curl = curl_init();
        curl_setopt_array($curl, $options);

// Execute the request
        $response = curl_exec($curl);

// Close the cURL session
        curl_close($curl);

// Extract the desired result using regular expressions
        $pattern = '/<table class="resultable">.*?<tr><td>الرقم بالحروف<\/td><td>(.*?)<\/td><\/tr>/s';
        preg_match($pattern, $response, $matches);

        if (isset($matches[1])) {
            $result = $matches[1];
        } else {
            echo 'Error';
        }

        $user_id = Auth::user()->id;
        $remaining = $request->remaining_value - $request->price;
        Applicant::insert([
            'user_id' =>  $user_id,
            'project_id' => $request->project_id,
            'transformation' => $request->transformation,
            'order_number' => $request->order_number,
            'step_name' => $request->step_name,
            'date' => $request->date,
            'section_name' => $request->section_name,
            'item_name' => $request->item_name,
            'item_value' => $request->item_value,
            'value' => $request->item_value,
            'remaining_value' => $remaining,
            'remaining_value_after' => $request->item_value,
            'price' => $request->price,
            'price_name' => $result,
            'priority_level' => $request->priority_level,
            'benefit_name' => $request->benefit_name,
            'en_benefit_name' => $request->en_benefit_name,
            'benefit_nationality' => $request->benefit_nationality,
            'country' => $request->country,
            'conversion_currency' => $request->conversion_currency,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'payment_date' => $request->payment_date,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);

        DB::table('multi_projects')
            ->where('item_name', $request->item_name)
            ->decrement('remaining_value', $request->price);

        $request->session()->flash('status', 'تم إرسال طلبك بنجاح');
        return redirect('/applicant/view');

    }

    public function ApplicantInternationalStore(Request $request) {
        $request->validate([
            'project_id' => 'required',
            'item_name' => 'required',
            'item_value' => 'required',
            'remaining_value' => 'required',
            'date' => 'required',
            'section_name' => 'required',
            'price' => 'required',
            'priority_level' => 'required',
            'account_number' => 'required',
            'bank_name' => 'required',
            'benefit_name' => 'required',
            'payment_date' => 'required',
        ],[
            'project_id.required' => 'اسم المشروع مطلوب',
            'item_name.required' => 'بند الصرف مطلوب',
            'item_value.required' => 'القيمة مطلوب',
            'remaining_value.required' => 'المبلغ المتبقي مطلوب',
            'date.required' => 'التاريخ مطلوب',
            'section_name.required' => 'اسم القسم مطلوب',
            'price.required' => 'المبلغ يجب ان يكون اقل من المبلغ المتبقي',
            'priority_level.required' => 'مستوى الاولوية مطلوب',
            'account_number.required' => 'رقم الحساب مطلوب',
            'bank_name.required' => 'اسم البنك مطلوب',
            'benefit_name.required' => 'اسم صاحب الحساب البنكي مطلوب',
            'payment_date.required' => 'تاريخ استحقاق الدفعة مطلوب',
        ]);
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number='.$request->price;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'authority: ahsibli.com',
                'accept: */*',
                'accept-language: en-US,en;q=0.9,ar;q=0.8',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'cookie: _gid=GA1.2.1200696489.1685273984; _gat_gtag_UA_166450035_1=1; _ga_ZSCB2L9KV5=GS1.1.1685273984.1.0.1685273984.0.0.0; _ga=GA1.1.554570941.1685273984; __gads=ID=5f01af1de5c542fc-22db0e9221e000e8:T=1685273984:RT=1685273984:S=ALNI_MYwwhfNBetLRtXSGsPPMr4LZdkrEA; __gpi=UID=00000c364d77d5ca:T=1685273984:RT=1685273984:S=ALNI_MZ7D_ac8H9HvpAIArSyXiZTznxl0Q',
                'origin: https://ahsibli.com',
                'referer: https://ahsibli.com/tool/number-to-words/',
                'sec-ch-ua: "Chromium";v="113", "Not-A.Brand";v="24"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
                'x-requested-with: XMLHttpRequest'
            )
        );

// Initialize cURL session
        $curl = curl_init();
        curl_setopt_array($curl, $options);

// Execute the request
        $response = curl_exec($curl);

// Close the cURL session
        curl_close($curl);

// Extract the desired result using regular expressions
        $pattern = '/<table class="resultable">.*?<tr><td>الرقم بالحروف<\/td><td>(.*?)<\/td><\/tr>/s';
        preg_match($pattern, $response, $matches);

        if (isset($matches[1])) {
            $result = $matches[1];
        } else {
            echo 'Error';
        }

        $user_id = Auth::user()->id;
        $remaining = $request->remaining_value - $request->price;
        Applicant::insert([
            'user_id' =>  $user_id,
            'project_id' => $request->project_id,
            'transformation' => $request->transformation,
            'order_number' => $request->order_number,
            'step_name' => $request->step_name,
            'date' => $request->date,
            'section_name' => $request->section_name,
            'item_name' => $request->item_name,
            'item_value' => $request->item_value,
            'value' => $request->item_value,
            'remaining_value' => $remaining,
            'remaining_value_after' => $request->item_value,
            'price' => $request->price,
            'price_name' => $result,
            'priority_level' => $request->priority_level,
            'benefit_name' => $request->benefit_name,
            'en_benefit_name' => $request->en_benefit_name,
            'benefit_nationality' => $request->benefit_nationality,
            'country' => $request->country,
            'conversion_currency' => $request->conversion_currency,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'payment_date' => $request->payment_date,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);

        DB::table('multi_projects')
            ->where('item_name', $request->item_name)
            ->decrement('remaining_value', $request->price);

        $request->session()->flash('status', 'تم إرسال طلبك بنجاح');
        return redirect('/applicant/view');
    }

    public function ApplicantEdit($id) {
        $user_id = Auth::user()->id;

        $sections = MultiSections::where('user_id', $user_id)->get();
        $applicant = Applicant::find($id);
        $projects = projects::where('status_id', 13)->get();
        $applicantManager = ApplicantManager::where('applicant_id', $id)->first();
        $financeManager = FinanceManager::where('applicant_id', $id)->first();
        return view('applicant.edit_order', compact('sections', 'applicant', 'applicantManager', 'financeManager', 'projects'));
    }

    public function ApplicantUpdate(Request $request, $id) {
        $request->validate([
            'project_id' => 'required',
            'item_name' => 'required',
            'item_value' => 'required',
            'remaining_value' => 'required',
            'date' => 'required',
            'section_name' => 'required',
            'price' => 'required',
            'priority_level' => 'required',
            'account_number' => 'required',
            'bank_name' => 'required',
            'payment_date' => 'required',
        ],[
            'project_id.required' => 'اسم المشروع مطلوب',
            'item_name.required' => 'بند الصرف مطلوب',
            'item_value.required' => 'القيمة مطلوب',
            'remaining_value.required' => 'المبلغ المتبقي مطلوب',
            'date.required' => 'التاريخ مطلوب',
            'section_name.required' => 'اسم القسم مطلوب',
            'price.required' => 'المبلغ يجب ان يكون اقل من المبلغ المتبقي',
            'priority_level.required' => 'مستوى الاولوية مطلوب',
            'account_number.required' => 'رقم الحساب مطلوب',
            'bank_name.required' => 'اسم البنك مطلوب',
            'payment_date.required' => 'تاريخ استحقاق الدفعة مطلوب',
        ]);
        $url = 'https://ahsibli.com/wp-admin/admin-ajax.php?action=date_numbers_1';
        $data = 'number='.$request->price;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'authority: ahsibli.com',
                'accept: */*',
                'accept-language: en-US,en;q=0.9,ar;q=0.8',
                'content-type: application/x-www-form-urlencoded; charset=UTF-8',
                'cookie: _gid=GA1.2.1200696489.1685273984; _gat_gtag_UA_166450035_1=1; _ga_ZSCB2L9KV5=GS1.1.1685273984.1.0.1685273984.0.0.0; _ga=GA1.1.554570941.1685273984; __gads=ID=5f01af1de5c542fc-22db0e9221e000e8:T=1685273984:RT=1685273984:S=ALNI_MYwwhfNBetLRtXSGsPPMr4LZdkrEA; __gpi=UID=00000c364d77d5ca:T=1685273984:RT=1685273984:S=ALNI_MZ7D_ac8H9HvpAIArSyXiZTznxl0Q',
                'origin: https://ahsibli.com',
                'referer: https://ahsibli.com/tool/number-to-words/',
                'sec-ch-ua: "Chromium";v="113", "Not-A.Brand";v="24"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-origin',
                'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36',
                'x-requested-with: XMLHttpRequest'
            )
        );

// Initialize cURL session
        $curl = curl_init();
        curl_setopt_array($curl, $options);

// Execute the request
        $response = curl_exec($curl);

// Close the cURL session
        curl_close($curl);

// Extract the desired result using regular expressions
        $pattern = '/<table class="resultable">.*?<tr><td>الرقم بالحروف<\/td><td>(.*?)<\/td><\/tr>/s';
        preg_match($pattern, $response, $matches);

        if (isset($matches[1])) {
            $result = $matches[1];
        } else {
            echo 'Error';
        }
        $remaining = $request->remaining_value - $request->price;
        Applicant::findOrFail($id)->update([
            'step_name' => $request->step_name,
            'date' => $request->date,
            'section_name' => $request->section_name,
            'item_name' => $request->item_name,
            'item_value' => $request->item_value,
            'value' => $request->item_value,
            'remaining_value' => $remaining,
            'remaining_value_after' => $request->item_value,
            'price' => $request->price,
            'price_name' => $result,
            'priority_level' => $request->priority_level,
            'benefit_name' => $request->benefit_name,
            'en_benefit_name' => $request->en_benefit_name,
            'benefit_nationality' => $request->benefit_nationality,
            'country' => $request->country,
            'conversion_currency' => $request->conversion_currency,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'payment_date' => $request->payment_date,
            'description' => $request->description,
            'status_id' => 1,
            'created_at' => Carbon::now(),
        ]);

        DB::table('projects')
            ->where('id', $request->project_name)
            ->decrement('remaining_value', $request->price);

        DB::table('multi_projects')
            ->where('item_name', $request->item_name)
            ->decrement('remaining_value', $request->price);

        $request->session()->flash('status', 'تم تعديل طلبك بنجاح');
        return redirect('/applicant/view');

    }

    public function applicantDelete($id) {
        Applicant::findOrFail($id)->delete();
        Session()->flash('status', 'تم حذف الطلب بنجاح');
        return redirect('/applicant/view');
    }

    public function getOrderNumber($project_id) {
        $project = projects::find($project_id);

        return response()->json(['project_code' => $project->project_code]);
    }

    public function getLastOrderNumber($project_id)
    {
        $lastOrderNumber = DB::table('applicants')
            ->where('project_id', $project_id)
            ->orderBy('order_number', 'desc')
            ->value('order_number');

        return response()->json(['last_order_number' => $lastOrderNumber]);
    }

    public function getSectionName($project_id)
    {
        $project = projects::find($project_id);

        return response()->json(['section_name' => $project->section_name]);
    }

    public function getStepNames($project_id)
    {
        $steps = MultiStep::where('project_id', $project_id)->pluck('step_name');

        return response()->json(['step_names' => $steps]);
    }

    public function getItemNames($step_name)
    {
        $step = MultiStep::where('step_name', $step_name)->first();

        if ($step) {
            $items = MultiProject::where('step_id', $step->id)->pluck('item_name');
            return response()->json(['item_names' => $items]);
        }

        // Handle the case where the step doesn't exist
        return response()->json(['item_names' => []]);
    }

    public function getItemValue($itemName, Request $request)
    {
        $projectId = $request->input('project_name');

        $itemValue = MultiProject::where('project_id', $projectId)
            ->where('item_name', $itemName)
            ->value('item_value');

        return response()->json($itemValue);
    }

    public function getRemainingValue($itemName, Request $request)
    {
        $projectId = $request->input('project_name');

        $remainingValue = MultiProject::where('project_id', $projectId)
            ->where('item_name', $itemName)
            ->value('remaining_value');

        return response()->json($remainingValue);
    }

    public function ApplicantEye($id) {
        $user_id = Auth::user()->id;

        $sections = MultiSections::where('user_id', $user_id)->get();
        $applicant = Applicant::find($id);
        $reply = FinanceManager::first();
        return view('applicant.applicant_eye', compact('sections', 'applicant', 'reply'));
    }

    public function applicantBack() {
        return redirect('/applicant/view');
    }

    public function ApplicantReplyInquiry(Request $request, $id) {

        $request->validate([
            'inquiry'=> 'required',
            'reply_inquiry' => 'required'
        ],[
            'inquiry.required' => 'الاستفسار مطلوب',
            'reply_inquiry.required' => ' الرد على الاستفسار مطلوب',
        ]);

        FinanceManager::where('applicant_id', $id)->update([
            'inquiry' => $request->inquiry,
            'reply_inquiry' => $request->reply_inquiry,
            'created_at' => Carbon::now(),
        ]);

        DB::table('applicants')
            ->where('id', $id)
            ->update(['status_id' => 9]);
        Session()->flash('status', 'تم إرسال الرد بنجاح');
        return redirect('/applicant/view');
    }

    public function ApplicantReturnDate(Request $request, $id) {
        Applicant::findOrFail($id)->update([
            'payment_date' => $request->payment_date,
            'status_id' => 11,
            'created_at' => Carbon::now(),
        ]);

        Session()->flash('status', 'تم  إعادة الإرسال بنجاح');
        return redirect('/applicant/view');
    }

    public function ReloadCaptcha() {

        return response()->json(['captcha'=>captcha_img('math')]);
    }


}
