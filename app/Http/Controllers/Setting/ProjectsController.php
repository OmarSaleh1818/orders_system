<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\MultiProject;
use App\Models\MultiStep;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MultiSections;
use App\Models\projects;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProjectsController extends Controller
{

    public function ProjectView() {

        $user_id = Auth::user()->id;
        $projects = projects::all();
        return view('project.project_view', compact('projects'));
    }

    public function AddProject() {

        $user_id = Auth::user()->id;
        $sections = MultiSections::where('user_id', $user_id)->get();
        return view('project.add_project', compact('sections'));
    }

    public function ProjectStore(Request $request) {

        $request->validate([
            'date' => 'required',
            'project_name' => 'required',
            'step_name' => 'required',
            'item_name' => 'required',
            'item_value' => 'required',
            'total' => 'required',
            'section_name' => 'required',
        ],[
            'date.required' => 'التاريخ مطلوب',
            'project_name.required' => 'اسم المشروع مطلوب',
            'step_name.required' => ' اسم المرحلة مطلوب',
            'item_name.required' => 'بند الصرف مطلوب',
            'item_value.required' => 'قيمة البند  مطلوب',
            'total.required' => 'المجموع  مطلوب',
            'section_name.required' => 'اسم القسم مطلوب',
        ]);

        $user_id = Auth::user()->id;

        $project_id = projects::insertGetId([
            'user_id' =>  $user_id,
            'date' => $request->date,
            'project_name' => $request->project_name,
            'total' => $request->total,
            'remaining_value' => $request->total,
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        $step_name = $request->step_name;
        $item_name = $request->item_name;
        $item_value = $request->item_value;
        $due_date = $request->due_date;
        foreach ($step_name as $step) {
            $p_name = $step;
            $step_id = MultiStep::insertGetId([
                'project_id' => $project_id,
                'step_name' => $p_name,
                'created_at' => Carbon::now(),
            ]);

            foreach ($item_name as $index => $item) {
                $s_name = $item;
                $s_value = $item_value[$index];
                $s_date = $due_date[$index];

                MultiProject::insert([
                    'project_id' => $project_id,
                    'step_id' => $step_id,
                    'item_name' => $s_name,
                    'item_value' => $s_value,
                    'remaining_value' => $s_value,
                    'due_date' => $s_date,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        $request->session()->flash('status', 'تم اضافة المشروع بنجاح');
        return redirect('/project/view');

    }

    public function ProjectEdit($id) {

        $user_id = Auth::user()->id;

        $sections = MultiSections::where('user_id', $user_id)->get();
        $multi_project = MultiProject::where('project_id', $id)->get();
        $project = projects::find($id);
        return view('project.edit_project', compact('sections', 'project', 'multi_project'));
    }

    public function ProjectUpdate(Request $request, $id) {

        $request->validate([
            'date' => 'required',
            'project_name' => 'required',
            'item_name' => 'required',
            'item_value' => 'required',
            'total' => [
            'required',
            Rule::unique('projects')->ignore($id), // Ignore the current project when checking uniqueness
            function ($attribute, $value, $fail) use ($id) {
                $existingTotal = projects::findOrFail($id)->total;

                if ($value > $existingTotal) {
                    $fail('المجموع يجب ان يكون نفسه او اقل .');
                }
            },
        ],
            'section_name' => 'required',
        ],[
            'date.required' => 'التاريخ مطلوب',
            'project_name.required' => 'اسم المشروع مطلوب',
            'item_name.required' => 'بند الصرف مطلوب',
            'item_value.required' => 'قيمة البند  مطلوب',
            'total.required' => 'المجموع  مطلوب',
            'section_name.required' => 'اسم القسم مطلوب',
        ]);

        projects::findOrFail($id)->update([
            'date' => $request->date,
            'project_name' => $request->project_name,
            'total' => $request->total,
            'remaining_value' => $request->total,
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        $multiIds = $request->input('multi');
        $item_name = $request->input('item_name');
        $item_value = $request->input('item_value');
        foreach ($multiIds as $key => $multiId) {
            $data = [
                'item_name' => $item_name[$key],
                'item_value' => $item_value[$key],
                'remaining_value' => $item_value[$key],
            ];
            MultiProject::where('id', $multiId)->update($data);
        }

        $request->session()->flash('status', 'تم تعديل المشروع بنجاح');
        return redirect('/project/view');
    }

    public function ProjectApprovedView() {

        $user_id = Auth::user()->id;
        $projects = projects::all();
        return view('project.project_approved' , compact('projects'));
    }

    public function ProjectSure($id) {

        DB::table('projects')
            ->where('id', $id)
            ->update(['status_id' => 6]);
        Session()->flash('status', 'تم اعتماد المشروع بنجاح');
        return redirect()->back();
    }

    public function ProjectEye($id) {
        $user_id = Auth::user()->id;

        $sections = MultiSections::where('user_id', $user_id)->get();
        $multi_project = MultiProject::where('project_id', $id)->get();
        $project = projects::find($id);
        return view('project.eye_project', compact('sections', 'project', 'multi_project'));
    }

    public function ProjectReject($id) {
        DB::table('projects')
            ->where('id', $id)
            ->update(['status_id' => 2]);
        Session()->flash('status', 'لم يتم اعتماد المشروع بنجاح');
        return redirect('/project/approved/view');
    }

    public function ProjectBack() {
        return redirect('/project/approved/view');
    }



}
