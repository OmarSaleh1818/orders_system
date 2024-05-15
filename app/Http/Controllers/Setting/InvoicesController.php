<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\IndirectCosts;
use App\Models\Invoices;
use App\Models\InvoicesAttachment;
use App\Models\InvoicesReject;
use App\Models\MultiInvoices;
use App\Models\MultiProject;
use App\Models\MultiSections;
use App\Models\MultiStep;
use App\Models\project_users;
use App\Models\projects;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{

    public function InvoicesView() {

        $invoices = Invoices::orderBy('id','DESC')->orderBy('status_id', 'ASC')->get();
        return view('invoices.invoices_view', compact('invoices'));
    }

    public function InvoicesEye($id) {

        $invoices = Invoices::find($id);
        $multi_invoices = MultiInvoices::where('invoice_id', $id)->get();
        return view('invoices.invoices_eye', compact('invoices', 'multi_invoices'));
    }

    public function InvoicesBack() {

        return redirect('/invoices/view');
    }

    public function InvoicesAdd() {

        $projects = projects::where('status_id', 13)->get();
        return view('invoices.invoices_add', compact('projects'));
    }

    public function InvoicesStore(Request $request) {

        $request->validate([
            'due_date' => 'required',
            'description' => 'required',
            'product' => 'required',
            'number' => 'required',
            'individual_price' => 'required',
            'total' => 'required',
            'attachment' => 'required|mimes:pdf,doc,docx|max:2024',
        ],[
            'due_date.required' => 'تاريخ الاستحقاق مطلوب',
            'description.required' => 'البيان مطلوب',
            'product.required' => 'المنتج مطلوب',
            'number.required' => 'العدد مطلوب',
            'individual_price.mimes' => 'السعر الفردي مطلوب',
            'total.required' => 'المجموع مطلوب',
            'attachment.mimes' => 'إرفاق الملف مطلوب',
        ]);

        $user_id = Auth::user()->id;
        $attachment = $request->file('attachment');
        $attachmentPath = $attachment->move("invoices", $attachment->getClientOriginalName());

        $invoices_id = Invoices::insertGetId([
            'user_id' => $user_id,
            'project_id' => $request->project_id,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'total' => $request->total,
            'attachment' => $attachmentPath,
            'created_at' => Carbon::now(),
        ]);
        $product = $request->product;
        $number = $request->number;
        $individual_price = $request->individual_price;
        $total_price = $request->total_price;
        foreach ($product as $index => $item) {
            $s_product = $item;
            $s_number = $number[$index];
            $s_individual_price = $individual_price[$index];
            $s_total_price = $total_price[$index];
            MultiInvoices::insert([
                'invoice_id' => $invoices_id,
                'product' => $s_product,
                'number' => $s_number,
                'individual_price' => $s_individual_price,
                'total_price' => $s_total_price,
                'created_at' => Carbon::now(),
            ]);
        }

        Session()->flash('status', 'تم إصدار فاتورة بنجاح');
        return redirect('/invoices/view');
    }

    public function InvoicesSure($id) {

        DB::table('invoices')
            ->where('id', $id)
            ->update(['status_id' => 3]);
        Session()->flash('status', 'تم الاعتماد بنجاح');
        return redirect('/invoices/view');
    }

    public function InvoicesReject(Request $request, $id) {

        $request->validate([
            'reject_reason'=> 'required'
        ],[
            'reject_reason.required' => 'السبب مطلوب'
        ]);
        $existingRecord = InvoicesReject::where('invoice_id', $id)->first();
        if ($existingRecord) {
            $existingRecord->update([
                'reject_reason' => $request->reject_reason,
                'created_at' => Carbon::now(),
            ]);
        } else {
            InvoicesReject::insert([
                'invoice_id' => $id,
                'reject_reason' => $request->reject_reason,
                'created_at' => Carbon::now(),
            ]);
        }
        DB::table('invoices')
            ->where('id', $id)
            ->update(['status_id' => 2]);
        Session()->flash('status', 'لم يتم الاعتماد ');
        return redirect('/invoices/view');
    }

    public function InvoicesEdit($id) {

        $projects = projects::where('status_id', 13)->get();
        $invoices = Invoices::find($id);
        $multi_invoices = MultiInvoices::where('invoice_id', $id)->get();
        return view('invoices.invoices_edit', compact('invoices', 'multi_invoices', 'projects'));
    }

    public function InvoicesUpdate(Request $request, $id) {
        $request->validate([
            'due_date' => 'required',
            'description' => 'required',
            'product' => 'required',
            'number' => 'required',
            'individual_price' => 'required',
            'total' => 'required',
        ],[
            'due_date.required' => 'تاريخ الاستحقاق مطلوب',
            'description.required' => 'البيان مطلوب',
            'product.required' => 'المنتج مطلوب',
            'number.required' => 'العدد مطلوب',
            'individual_price.mimes' => 'السعر الفردي مطلوب',
            'total.required' => 'المجموع مطلوب',
        ]);

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $attachmentPath = $attachment->move("invoices", $attachment->getClientOriginalName());
            Invoices::find($id)->update([
                'attachment' => $attachmentPath,
            ]);
        }

        Invoices::find($id)->update([
            'project_id' => $request->project_id,
            'due_date' => $request->due_date,
            'description' => $request->description,
            'total' => $request->total,
            'status_id' => 1,
        ]);
        $multiIds = $request->input('multi');
        $product = $request->input('product');
        $number = $request->input('number');
        $individual_price = $request->input('individual_price');
        $total_price = $request->input('total_price');

// Update existing items
        foreach ($multiIds as $key => $multiId) {
            $data = [
                'product' => $product[$key],
                'number' => $number[$key],
                'individual_price' => $individual_price[$key],
                'total_price' => $total_price[$key],
            ];
            MultiInvoices::where('id', $multiId)->update($data);
        }

// Check for new items
        if (count($product) > count($multiIds)) {
            for ($i = count($multiIds); $i < count($product); $i++) {
                $newItemData = [
                    'invoice_id' => $id,
                    'product' => $product[$i],
                    'number' => $number[$i],
                    'individual_price' => $individual_price[$i],
                    'total_price' => $total_price[$i],
                ];
                MultiInvoices::create($newItemData);
            }
        }

// Check for deleted items
        if (count($product) < count($multiIds)) {
            for ($i = count($product); $i < count($multiIds); $i++) {
                MultiInvoices::where('id', $multiIds[$i])->delete();
            }
        }

        $request->session()->flash('status', 'تم التعديل  بنجاح');
        return redirect('/invoices/view');

    }

    public function InvoicesManagerSure($id) {

        DB::table('invoices')
            ->where('id', $id)
            ->update(['status_id' => 4]);
        Session()->flash('status', 'تم الاعتماد بنجاح');
        return redirect('/invoices/view');
    }

    public function InvoicesAttachment(Request $request, $id) {

        $request->validate([
            'invoice_attachment' => 'required|mimes:pdf,doc,docx',
        ], [
            'invoice_attachment.required' => 'إرفاق الملف مطلوب',
            'invoice_attachment.mimes' => 'يجب أن يكون الملف من نوع PDF أو DOC',
        ]);
        $file = $request->file('invoice_attachment');
        $filePath = $file->move("invoices", $file->getClientOriginalName());
        if($filePath) {
            InvoicesAttachment::insert([
                'invoice_id' => $id,
                'invoice_attachment' => $filePath,
                'created_at' => now(),
            ]);

            DB::table('invoices')
                ->where('id', $id)
                ->update(['status_id' => 5]);
            Session()->flash('status', 'تم التنفيذ بنجاح');
            return redirect('/invoices/view');
        } else {
            Session()->flash('status', 'للأسف لم يتم ');
            return redirect('/invoices/view');
        }

    }


}
