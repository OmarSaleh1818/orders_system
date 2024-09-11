<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\MultiProject;
use App\Models\MultiStep;
use App\Models\OpenProject;
use App\Models\project_users;
use App\Models\ProjectManager;
use App\Models\User;
use App\Models\IndirectCosts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Sections;
use App\Models\MultiSections;
use App\Models\projects;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;


class ProjectsController extends Controller
{
//    function __construct()
//    {
//
//        $this->middleware('permission:المشاريع', ['only' => ['ProjectView', 'ProjectEye']]);
//        $this->middleware('permission:المشاريع', ['only' => ['AddProject','ProjectStore', 'ProjectEdit', 'ProjectUpdate']]);
//        $this->middleware('permission:معتمد المشروع', ['only' => ['ProjectApprovedView','ProjectSure']]);
//        $this->middleware('permission:معتمد المشروع', ['only' => ['ProjectReject', 'ProjectManagerEye']]);
//
//    }
    public function ProjectView() {

        $sections = Sections::all();
        $projects = projects::orderBy('id','DESC')->orderBy('status_id', 'ASC')->get();
        return view('project.project_view', compact('sections', 'projects'));
    }

    public function filterProjects(Request $request)
    {
        $sectionName = $request->input('section_name');

        // Get all projects if no section is selected
        if (empty($sectionName)) {
            $projects = projects::all();
        } else {
            // Filter projects by section name
            $projects = projects::where('section_name', $sectionName)->get();
        }

        return response()->json([
            'projects' => $projects
        ]);
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
            'project_name' => ['required', 'string', 'max:255', 'unique:'.projects::class],
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
            'price_number' => $request->price_number,
            'total' => $request->total,
            'remaining_value' => $request->total,
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);

        IndirectCosts::insert([
            'project_id' => $project_id,
            'management' => $request->management,
            'indirect_costs' => $request->indirect_costs,
            'total_costs' => $request->total_costs,
            'monthly_benefit' => $request->monthly_benefit,
            'per_month' => $request->per_month,
            'percentage_total' => $request->percentage_total,
            'benefit_value' => $request->benefit_value,
            'total_project_costs' => $request->total_project_costs,
            'target_profit_percentage' => $request->target_profit_percentage,
            'actual_profit_value' => $request->actual_profit_value,
            'before_tax' => $request->before_tax,
            'value_tax' => $request->value_tax,
            'after_tax' => $request->after_tax,
            'created_at' => Carbon::now(),
        ]);
        // Get all request data
        $stepNames = $request->input('step_name');
        $stepIds = $request->input('step_id');
        $itemNames = $request->input('item_name');
        $itemValues = $request->input('item_value');
        $otherItemNames = $request->input('other_item_name', []);
        $stepItemIds = $request->input('step_item_id');

        foreach ($stepNames as $index => $stepName) {
            $step = MultiStep::create([
                'project_id' => $project_id,
                'step_name' => $stepName,
                'created_at' => Carbon::now(),
            ]);

            foreach ($stepItemIds as $itemIndex => $stepItemId) {
                if ($stepItemId == $stepIds[$index]) {
                    $itemName = $itemNames[$itemIndex];
                    if (isset($otherItemNames[$itemIndex]) && !empty($otherItemNames[$itemIndex])) {
                        $itemName = $otherItemNames[$itemIndex];
                    }
                    MultiProject::create([
                        'project_id' => $project_id,
                        'step_id' => $step->id,
                        'item_name' => $itemName,
                        'item_value' => $itemValues[$itemIndex],
                        'remaining_value' => $itemValues[$itemIndex],
                        'created_at' => Carbon::now(),
                    ]);
                }
            }
        }
       

        $request->session()->flash('status', 'تم إضافة التسعيرة بنجاح');
        return redirect('/manager/project/view');
    }

    public function ProjectEdit($id) {

        $user_id = Auth::user()->id;

        $steps = MultiStep::where('project_id', $id)->get();
        $multi_project = MultiProject::where('project_id', $id)->get();
        $project_users = project_users::where('project_id', $id)->get();
        $projectManager = ProjectManager::where('project_id', $id)->first();
        $indirect_costs = IndirectCosts::where('project_id', $id)->first();
        $project = projects::find($id);
        $sections = MultiSections::where('user_id', $user_id)->get();
        return view('project.edit_project', compact('sections', 'project',
            'multi_project', 'steps', 'project_users', 'projectManager', 'indirect_costs'));
    }

    public function ProjectUpdate(Request $request, $id) {

        $request->validate([
            'date' => 'required',
            'project_name' => 'required',
            'step_name' => 'required' ,
            'item_name' => 'required',
            'item_value' => 'required',
            'total' => 'required',
            'section_name' => 'required',
        ],[
            'date.required' => 'التاريخ مطلوب',
            'project_name.required' => 'اسم المشروع مطلوب',
            'step_name.required' => 'اسم المرحلة مطلوب',
            'item_name.required' => 'بند الصرف مطلوب',
            'item_value.required' => 'قيمة البند  مطلوب',
            'total.required' => 'المجموع  مطلوب',
            'section_name.required' => 'اسم القسم مطلوب',
        ]);

        projects::findOrFail($id)->update([
            'date' => $request->date,
            'project_name' => $request->project_name,
            'price_number' => $request->price_number,
            'total' => $request->total,
            'remaining_value' => $request->total,
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);

        IndirectCosts::where('project_id', $id)->update([
            'management' => $request->management,
            'indirect_costs' => $request->indirect_costs,
            'total_costs' => $request->total_costs,
            'monthly_benefit' => $request->monthly_benefit,
            'per_month' => $request->per_month,
            'percentage_total' => $request->percentage_total,
            'benefit_value' => $request->benefit_value,
            'total_project_costs' => $request->total_project_costs,
            'target_profit_percentage' => $request->target_profit_percentage,
            'actual_profit_value' => $request->actual_profit_value,
            'before_tax' => $request->before_tax,
            'value_tax' => $request->value_tax,
            'after_tax' => $request->after_tax,
            'created_at' => Carbon::now(),
        ]);

        // Track the IDs of the steps and items that are inserted or updated
        $insertedStepIds = [];
        $insertedItemIds = [];

        // Handle updated or new steps
        foreach ($request->step_id as $index => $stepId) {
            $stepData = [
                'project_id' => $id,
                'step_name' => $request->step_name[$index],
            ];

            if (strpos($stepId, 'new') === false) {
                // Update existing step
                MultiStep::where('id', $stepId)->update($stepData);
            } else {
                // Create new step
                $newStep = MultiStep::create($stepData);
                $stepId = $newStep->id;
                $insertedStepIds[] = $stepId;
            }

            // Handle items for each step
            foreach ($request->item_id as $itemIndex => $itemId) {
                if ($request->step_item_id[$itemIndex] == $request->step_id[$index] || in_array($request->step_id[$index], $insertedStepIds)) {
                    $itemData = [
                        'step_id' => $stepId,
                        'item_name' => $request->item_name[$itemIndex] === 'أخرى' ? $request->other_item_name[$itemIndex] : $request->item_name[$itemIndex],
                        'item_value' => $request->item_value[$itemIndex],
                        'remaining_value' => $request->item_value[$itemIndex],
                        'project_id' => $id,
                        'created_at' => now(),
                    ];

                    if (strpos($itemId, 'new') === false) {
                        // Update existing item
                        MultiProject::where('id', $itemId)->update($itemData);
                    } else {
                        // Create new item
                        MultiProject::create($itemData);
                    }
                }
            }
        }

        // // Handle deleted steps and items
        // $deletedSteps = explode(',', $request->input('deleted_steps', ''));
        // $deletedItems = explode(',', $request->input('deleted_items', ''));

        // if (!empty($deletedSteps)) {
        //     MultiProject::whereIn('step_id', $deletedSteps)->where('project_id', $id)->delete();
        //     MultiStep::whereIn('id', $deletedSteps)->where('project_id', $id)->delete();
        // }

        // if (!empty($deletedItems)) {
        //     MultiProject::whereIn('id', $deletedItems)->delete();
        // }


        DB::table('projects')
            ->where('id', $id)
            ->update(['status_id' => 1]);

        $request->session()->flash('status', 'تم تعديل التسعيرة بنجاح');
        return redirect('/manager/project/view');
    }

    public function ProjectSure($id) {

        DB::table('projects')
            ->where('id', $id)
            ->update(['status_id' => 6]);
        Session()->flash('status', 'تم اعتماد التسعيرة بنجاح');
        return redirect('/manager/project/view');
    }

    public function PriceSure($id) {

        DB::table('projects')
            ->where('id', $id)
            ->update(['status_id' => 7]);
        Session()->flash('status', 'تم اعتماد التسعيرة بنجاح');
        return redirect('/manager/project/view');
    }

    public function ProjectEye($id) {
        $user_id = Auth::user()->id;

        $steps = MultiStep::where('project_id', $id)->get();
        $sections = MultiSections::where('user_id', $user_id)->get();
        $multi_project = MultiProject::where('project_id', $id)->get();
        $project_users = project_users::where('project_id', $id)->get();
        $indirect_costs = IndirectCosts::where('project_id', $id)->first();
        $project = projects::find($id);
        return view('project.eye_project', compact('sections', 'project',
            'multi_project', 'steps', 'project_users', 'indirect_costs'));
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
        Session()->flash('status', 'لم يتم اعتماد التسعيرة ');
        return redirect('/manager/project/view');
    }

    public function ProjectBack() {
        return redirect('/project/approved/view');
    }

    public function Back() {
        return redirect('/manager/project/view');
    }

    public function ProjectRepeat($id) {
        $user_id = Auth::user()->id;

        $steps = MultiStep::where('project_id', $id)->with('items')->get();
        $multi_project = MultiProject::where('project_id', $id)->get();
        $project_users = project_users::where('project_id', $id)->get();
        $projectManager = ProjectManager::where('project_id', $id)->first();
        $indirect_costs = IndirectCosts::where('project_id', $id)->first();
        $project = projects::find($id);
        $sections = MultiSections::where('user_id', $user_id)->get();
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
        return view('project.repeat_project', compact('sections', 'project',
            'multi_project', 'steps', 'project_users', 'projectManager', 'indirect_costs', 'formattedPriceNumber'));
    }

    public function ProjectUpdateManager(Request $request, $id) {
       // Update user_id in the projects and open_projects tables
        projects::findOrFail($id)->update([
            'user_id' => $request->user_id
        ]);

        OpenProject::where('project_id', $id)->update([
            'user_id' => $request->user_id
        ]);

        // Retrieve the updated user
        $user = User::findOrFail($request->user_id);

        // Check if the user has the role of "مدير مشروع", and assign if not
        $managerRole = Role::where('name', 'مدير مشروع')->first();

        if (!$user->roles()->where('name', 'مدير مشروع')->exists()) {
            $user->roles()->attach($managerRole); // Add the role
        }

        // Add or update the user in the project_users table
        project_users::updateOrCreate(
            [
                'project_id' => $id,         // The unique condition for the project
                'user_name' => $user->name,  // The user name as a unique key
            ],
            [
                'openProject_id' => $request->openProject_id,
                'user_name' => $user->name   // Ensure the user name is added if creating a new record
            ]
        );

        // Add the user ID to the project_users table if it doesn't exist
        if (!project_users::where('user_name', $user->name)->where('project_id', $id)->exists()) {
            project_users::create([
                'project_id' => $id,
                'openProject_id' => $request->openProject_id,
                'user_name' => $user->name,
            ]);
        }

        $request->session()->flash('status', 'تم تغيير مدير المشروع بنجاح');
        return redirect('project/approved/eye/'.$request->openProject_id);
    }



}
