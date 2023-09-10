<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Sections;

class SectionsController extends Controller
{

    public function SectionView() {

        $sections = Sections::all();
        return view('setting.section_view', compact('sections'));
    }

    public function SectionStore(Request $request) {

        $request->validate([
            'section_name' => 'required',
        ],[
            'section_name.required' => 'اسم القسم مطلوب',
        ]);
        Sections::insert([
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);
        $request->session()->flash('status', 'تم ادخال اسم الفرع بنجاح');
        return redirect()->back();
    }

    public function SectionEdit($id) {

        $section = Sections::findOrFail($id);
        return view('setting.section_edit', compact('section'));
    }

    public function SectionUpdate(Request $request, $id) {
        $request->validate([
            'section_name' => 'required',
        ],[
            'section.required' => 'اسم الفرع مطلوب',
        ]);

        Sections::findOrFail($id)->update([
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        $request->session()->flash('status', 'تم تعديل اسم القسم بنجاح');
        return redirect('/section/view');
    }

    public function SectionDelete($id) {
        Sections::findOrFail($id)->delete();
        Session()->flash('status', 'تم حذف القسم بنجاح');
        return redirect('/section/view');
    }


}