<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MultiSections;
use Illuminate\Support\Facades\Auth;

class ApplicantControllar extends Controller
{

    public function applicantView() {

        $user_id = Auth::user()->id;
        $applicants = Applicant::where('user_id', $user_id)->get();
        return view('applicant.applicant_view', compact('applicants'));
    }

    public function AddOrder() {
        $user_id = Auth::user()->id;

        $sections = MultiSections::where('user_id', $user_id)->get();

        return view('applicant.add_order', compact('sections'));
    }

    public function ApplicantStore(Request $request) {

        $request->validate([
            'date' => 'required',
            'section_name' => 'required',
            'price' => 'required',
            'priority_level' => 'required',
            'account_number' => 'required',
            'bank_name' => 'required',
            'bank_name_account' => 'required',
            'payment_date' => 'required',
            'order_name' => 'required',
        ],[
            'date.required' => 'التاريخ مطلوب',
            'section_name.required' => 'اسم القسم مطلوب',
            'price.required' => 'المبلغ مطلوب',
            'priority_level.required' => 'مستوى الاولوية مطلوب',
            'account_number.required' => 'رقم الحساب مطلوب',
            'bank_name.required' => 'اسم البنك مطلوب',
            'bank_name_account.required' => 'اسم صاحب الحساب البنكي مطلوب',
            'payment_date.required' => 'تاريخ استحقاق الدفعة مطلوب',
            'order_name.required' => 'البيان مطلوب',
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
        Applicant::insert([
            'user_id' =>  $user_id,
            'date' => $request->date,
            'section_name' => $request->section_name,
            'price' => $request->price,
            'price_name' => $result,
            'priority_level' => $request->priority_level,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'bank_name_account' => $request->bank_name_account,
            'payment_date' => $request->payment_date,
            'order_name' => $request->order_name,
            'contract_number' => $request->contract_number,
            'project_name' => $request->project_name,
            'stage_name' => $request->stage_name,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم اضافة طلبك بنجاح');
        return redirect('/applicant/view');

    }

    public function ApplicantEdit($id) {
        $user_id = Auth::user()->id;

        $sections = MultiSections::where('user_id', $user_id)->get();
        $applicant = Applicant::find($id);
        return view('applicant.edit_order', compact('sections', 'applicant'));
    }

    public function ApplicantUpdate(Request $request, $id) {
        $request->validate([
            'date' => 'required',
            'section_name' => 'required',
            'price' => 'required',
            'priority_level' => 'required',
            'account_number' => 'required',
            'bank_name' => 'required',
            'bank_name_account' => 'required',
            'payment_date' => 'required',
            'order_name' => 'required',
        ],[
            'date.required' => 'التاريخ مطلوب',
            'section_name.required' => 'اسم القسم مطلوب',
            'price.required' => 'المبلغ مطلوب',
            'priority_level.required' => 'مستوى الاولوية مطلوب',
            'account_number.required' => 'رقم الحساب مطلوب',
            'bank_name.required' => 'اسم البنك مطلوب',
            'bank_name_account.required' => 'اسم صاحب الحساب البنكي مطلوب',
            'payment_date.required' => 'تاريخ استحقاق الدفعة مطلوب',
            'order_name.required' => 'البيان مطلوب',
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
        Applicant::findOrFail($id)->update([
            'date' => $request->date,
            'section_name' => $request->section_name,
            'price' => $request->price,
            'price_name' => $result,
            'priority_level' => $request->priority_level,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'bank_name_account' => $request->bank_name_account,
            'payment_date' => $request->payment_date,
            'order_name' => $request->order_name,
            'contract_number' => $request->contract_number,
            'project_name' => $request->project_name,
            'stage_name' => $request->stage_name,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم تعديل طلبك بنجاح');
        return redirect('/applicant/view');

    }

    public function applicantDelete($id) {
        Applicant::findOrFail($id)->delete();
        Session()->flash('status', 'تم حذف الطلب بنجاح');
        return redirect('/applicant/view');
    }



}
