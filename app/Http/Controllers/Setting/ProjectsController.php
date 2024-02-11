<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\MultiProject;
use App\Models\MultiStep;
use App\Models\project_users;
use App\Models\ProjectManager;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MultiSections;
use App\Models\projects;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class ProjectsController extends Controller
{
    function __construct()
    {

        $this->middleware('permission:المشاريع', ['only' => ['ProjectView', 'ProjectEye']]);
        $this->middleware('permission:المشاريع', ['only' => ['AddProject','ProjectStore', 'ProjectEdit', 'ProjectUpdate']]);
        $this->middleware('permission:معتمد المشروع', ['only' => ['ProjectApprovedView','ProjectSure']]);
        $this->middleware('permission:معتمد المشروع', ['only' => ['ProjectReject', 'ProjectManagerEye']]);

    }
    public function ProjectView() {

        $projects = projects::orderBy('id','DESC')->orderBy('status_id', 'ASC')->get();
        return view('project.project_view', compact('projects'));
    }

    public function AddProject() {
        $lastPriceNumber = projects::orderBy('id', 'desc')->value('price_number');

        if ($lastPriceNumber === null) {
            // If no previous entry exists, start with "0001"
            $newPriceNumber = 1;
        } else {
            // Increment the last price number by 1
            $newPriceNumber = $lastPriceNumber + 1;
        }
        // Format the new price number with leading zeros
        $formattedPriceNumber = str_pad($newPriceNumber, 4, '0', STR_PAD_LEFT);

        $user_id = Auth::user()->id;
        $sections = MultiSections::where('user_id', $user_id)->get();
        return view('project.add_project', compact('sections', 'formattedPriceNumber'));
    }

    public function getUsersBySection(Request $request)
    {
        $sectionName = $request->input('section_name');

        $users = MultiSections::where('section_name', $sectionName)
            ->join('users', 'multi_sections.user_id', '=', 'users.id')
            ->pluck('users.name', 'multi_sections.user_id');

        return response()->json($users);
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
            'customer_type'=> 'required',
            'user_name' => 'required',
        ],[
            'date.required' => 'التاريخ مطلوب',
            'project_name.required' => 'اسم المشروع مطلوب',
            'step_name.required' => ' اسم المرحلة مطلوب',
            'item_name.required' => 'بند الصرف مطلوب',
            'item_value.required' => 'قيمة البند  مطلوب',
            'total.required' => 'المجموع  مطلوب',
            'section_name.required' => 'اسم القسم مطلوب',
            'customer_type.requied' => 'نوع العميل مطلوب',
            'user_name.required' => 'اختيار الموظفين مطلوب'
        ]);
        $user_id = Auth::user()->id;

        $project_id = projects::insertGetId([
            'user_id' =>  $user_id,
            'date' => $request->date,
            'project_name' => $request->project_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project_days' => $request->project_days,
            'price_number' => $request->price_number,
            'customer_type' => $request->customer_type,
            'customer_name' => $request->customer_name,
            'benefit' => $request->benefit,
            'project_code' => $request->project_code,
            'total' => $request->total,
            'remaining_value' => $request->total,
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        $step_name = $request->step_name;
        $item_name = $request->item_name;
        $item_value = $request->item_value;
        $due_date = $request->due_date;
        $user_name = $request->input('user_name');
        $numberStepItems = $request->number_step;
        $stepId = 0;
        $itemOfEachStep = 0; // the value of index I should loop until each step
        $startIndex = 0; // the value of index I should loop until each step
        foreach ($step_name as $step) {
            $p_name = $step;
            $step_id = MultiStep::insertGetId([
                'project_id' => $project_id,
                'step_name' => $p_name,
                'created_at' => Carbon::now(),
            ]);
            $numberOfStepItem = $numberStepItems[$stepId];
            $stepId++;
            $itemOfEachStep = $itemOfEachStep+$numberOfStepItem;
            for($i = $startIndex ; $i < $itemOfEachStep; $i++ ){
                $s_name = $item_name[$i];
                $s_value = $item_value[$i];
                $s_date = $due_date[$i];

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
            $startIndex=+ $numberOfStepItem;
/*                foreach ($item_name as $index => $item) {
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
                }*/
        }
        foreach ($user_name as $user) {
            project_users::insert([
                'project_id' => $project_id,
                'user_name' => $user,
                'created_at' => Carbon::now(),
            ]);
        }

        $request->session()->flash('status', 'تم إضافة المشروع بنجاح');
        return redirect('/manager/project/view');

    }

    public function ProjectEdit($id) {

        $user_id = Auth::user()->id;

        $steps = MultiStep::where('project_id', $id)->get();
        $multi_project = MultiProject::where('project_id', $id)->get();
        $project_users = project_users::where('project_id', $id)->get();
        $projectManager = ProjectManager::where('project_id', $id)->first();
        $project = projects::find($id);
        $sections = MultiSections::where('user_id', $user_id)->get();
        return view('project.edit_project', compact('sections', 'project',
            'multi_project', 'steps', 'project_users', 'projectManager'));
    }

    public function ProjectUpdate(Request $request, $id) {

        $request->validate([
            'date' => 'required',
            'project_name' => 'required',
            'item_name' => 'required',
            'item_value' => 'required',
            'total' => 'required',
// [
//            'required',
//            Rule::unique('projects')->ignore($id), // Ignore the current project when checking uniqueness
//            function ($attribute, $value, $fail) use ($id) {
//                $existingTotal = projects::findOrFail($id)->total;
//
//                if ($value > $existingTotal) {
//                    $fail('المجموع يجب ان يكون نفسه او اقل .');
//                }
//            },
//        ],
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
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project_days' => $request->project_days,
            'price_number' => $request->price_number,
            'customer_type' => $request->customer_type,
            'customer_name' => $request->customer_name,
            'benefit' => $request->benefit,
            'project_code' => $request->project_code,
            'total' => $request->total,
            'remaining_value' => $request->total,
            'section_name' => $request->section_name,
            'created_at' => Carbon::now(),
        ]);

        $stepIds = $request->input('step');
        $step_name = $request->input('step_name');
        $multiIds = $request->input('multi');
        $item_name = $request->input('item_name');
        $item_value = $request->input('item_value');
        $user_names = $request->input('user_name');
        foreach ($stepIds as $key => $stepId) {
            $data = [
                'step_name' => $step_name[$key],
            ];
           MultiStep::where('id', $stepId)->update($data);
        }
        foreach ($multiIds as $key => $multiId) {
            $data = [
                'item_name' => $item_name[$key],
                'item_value' => $item_value[$key],
                'remaining_value' => $item_value[$key],
            ];
            MultiProject::where('id', $multiId)->update($data);
        }
        if (!empty($user_names)) {
            foreach ($user_names as $user_name) {
                $existingUser = project_users::where('project_id', $id)->where('user_name', $user_name)->first();
                if ($existingUser) {

                    $data = ['user_name' => $user_name];
                    project_users::where('id', $existingUser->id)->update($data);
                } else {

                    project_users::create([
                        'project_id' => $id,
                        'user_name' => $user_name
                    ]);
                }
            }
        }
        DB::table('projects')
            ->where('id', $id)
            ->update(['status_id' => 1]);

        $request->session()->flash('status', 'تم تعديل المشروع بنجاح');
        return redirect('/manager/project/view');
    }

    public function ProjectApprovedView() {

        $projects = projects::orderBy('id','DESC')->orderBy('status_id', 'ASC')->get();
        return view('project.project_approved' , compact('projects'));
    }

    public function ProjectSure($id) {

        DB::table('projects')
            ->where('id', $id)
            ->update(['status_id' => 6]);
        Session()->flash('status', 'تم اعتماد المشروع بنجاح');
        return redirect('/project/approved/view');
    }

    public function ProjectEye($id) {
        $user_id = Auth::user()->id;

        $steps = MultiStep::where('project_id', $id)->get();
        $sections = MultiSections::where('user_id', $user_id)->get();
        $multi_project = MultiProject::where('project_id', $id)->get();
        $project_users = project_users::where('project_id', $id)->get();
        $project = projects::find($id);
        return view('project.eye_project', compact('sections', 'project', 'multi_project', 'steps', 'project_users'));
    }

    public function ProjectReject(Request $request , $id) {
        $request->validate([
            'manager_reason'=> 'required'
        ],[
            'manager_reason.required' => 'السبب مطلوب'
        ]);
        $existingRecord = ProjectManager::where('project_id', $id)->first();
        if ($existingRecord) {
            $existingRecord->update([
                'manager_reason' => $request->manager_reason,
                'created_at' => Carbon::now(),
            ]);
        } else {
            ProjectManager::insert([
                'project_id' => $id,
                'manager_reason' => $request->manager_reason,
                'created_at' => Carbon::now(),
            ]);
        }
        DB::table('projects')
            ->where('id', $id)
            ->update(['status_id' => 2]);
        Session()->flash('status', 'لم يتم اعتماد المشروع ');
        return redirect('/project/approved/view');
    }

    public function ProjectBack() {
        return redirect('/project/approved/view');
    }

    public function Back() {
        return redirect('/manager/project/view');
    }

    public function ProjectManagerEye($id) {
        $user_id = Auth::user()->id;

        $steps = MultiStep::where('project_id', $id)->get();
        $sections = MultiSections::where('user_id', $user_id)->get();
        $multi_project = MultiProject::where('project_id', $id)->get();
        $project_users = project_users::where('project_id', $id)->get();
        $project = projects::find($id);
        return view('project.manager_eye', compact('sections', 'project', 'multi_project', 'steps', 'project_users'));
    }

    public function ProjectUpdateManager(Request $request, $id) {
        projects::findOrFail($id)->update([
           'user_id' => $request->user_id
        ]);
        $user = User::findOrFail($request->user_id);

        $managerRole = Role::where('name', 'مدير المشروع')->first();

        if (!$user->roles()->where('name', 'مدير المشروع')->exists()) {
            // Add the role "مدير المشروع" to the user's roles
            $user->roles()->attach($managerRole);
        }

        $request->session()->flash('status', 'تم تغيير مدير المشروع بنجاح');
        return redirect()->back();
    }



}
