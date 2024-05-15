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
        $step_name = $request->step_name;
        $item_name = $request->item_name;
        $item_value = $request->item_value;
        $numberStepItems = $request->number_step;
        $other_item_name = $request->other_item_name;
        $stepId = 0;
        $startIndex = 0; // Initialize the start index outside the loop

        foreach ($step_name as $step) {
            $p_name = $step;
            $step_id = MultiStep::insertGetId([
                'project_id' => $project_id,
                'step_name' => $p_name,
                'created_at' => Carbon::now(),
            ]);
            $numberOfStepItem = $numberStepItems[$stepId];

            for ($i = $startIndex; $i < $startIndex + $numberOfStepItem; $i++) {
                $s_name = $item_name[$i];
                $s_value = $item_value[$i];

                // Check if the current item is "أخرى" and use the value from the other_item_name input field
                if ($s_name === "أخرى") {
                    $s_name = $other_item_name;
                }

                MultiProject::insert([
                    'project_id' => $project_id,
                    'step_id' => $step_id,
                    'item_name' => $s_name,
                    'item_value' => $s_value,
                    'remaining_value' => $s_value,
                    'created_at' => Carbon::now(),
                ]);
            }

            $startIndex += $numberOfStepItem; // Update the start index for the next step
            $stepId++; // Increment the step ID
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
            'item_name' => 'required',
            'item_value' => 'required',
            'total' => 'required',
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

        $step_name = $request->step_name;
        $item_name = $request->item_name;
        $item_value = $request->item_value;
        $numberStepItems = $request->number_step;
        $other_item_name = $request->other_item_name;

// Track the IDs of the steps and items that are inserted or updated
        $insertedStepIds = [];
        $insertedItemIds = [];

// Delete steps and their items
        $existingStepIds = $request->step_id;
        $existingItemIds = $request->multi;
        $deleteSteps = array_diff($existingStepIds, $numberStepItems);
        foreach ($deleteSteps as $deleteStepIndex => $deleteStepId) {
            MultiProject::where('step_id', $deleteStepId)->delete();
            MultiStep::where('id', $deleteStepId)->delete();

            // Remove the deleted step and its items from the existingStepIds and existingItemIds arrays
            unset($existingStepIds[$deleteStepIndex]);
            unset($existingItemIds[$deleteStepIndex]);
        }
        $existingStepIds = array_values($existingStepIds);
        $existingItemIds = array_values($existingItemIds);

// Insert or update steps and their items
        foreach ($numberStepItems as $stepIndex => $stepId) {
            $stepName = $step_name[$stepIndex];

            if (in_array($stepId, $existingStepIds)) {
                // Existing step, update it
                MultiStep::where('id', $stepId)->update([
                    'step_name' => $stepName,
                    'updated_at' => now(),
                ]);
            } else {
                // New step, insert it
                $stepId = MultiStep::insertGetId([
                    'project_id' => $id,
                    'step_name' => $stepName,
                    'created_at' => now(),
                ]);
                $insertedStepIds[] = $stepId;
            }

            // Get the start and end index for items in this step
            $startIndex = array_sum(array_slice($numberStepItems, 0, $stepIndex));
            $endIndex = $startIndex + $numberStepItems[$stepIndex];

            // Insert or update items for this step
            for ($i = $startIndex; $i < $endIndex; $i++) {
                $itemId = $existingItemIds[$i] ?? null;
                $itemName = $item_name[$i];
                $itemValue = $item_value[$i];

                if ($itemName === "أخرى") {
                    $itemName = $other_item_name;
                }

                if ($itemId && MultiProject::where('id', $itemId)->exists()) {
                    // Existing item, update it
                    MultiProject::where('id', $itemId)->update([
                        'item_name' => $itemName,
                        'item_value' => $itemValue,
                        'remaining_value' => $itemValue,
                    ]);
                } else {
                    // New item, insert it
                    $itemId = MultiProject::insertGetId([
                        'project_id' => $id,
                        'step_id' => $stepId,
                        'item_name' => $itemName,
                        'item_value' => $itemValue,
                        'remaining_value' => $itemValue,
                        'created_at' => now(),
                    ]);
                    $insertedItemIds[] = $itemId;
                }
            }
        }

// Delete any remaining items that were not updated or inserted
        MultiProject::whereNotIn('id', $insertedItemIds)->delete();

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

        $steps = MultiStep::where('project_id', $id)->get();
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
        projects::findOrFail($id)->update([
           'user_id' => $request->user_id
        ]);
        OpenProject::findOrFail($request->openProject_user_id)->update([
            'user_id' => $request->user_id
        ]);
        $user = User::findOrFail($request->user_id);

        $managerRole = Role::where('name', 'مدير مشروع')->first();

        if (!$user->roles()->where('name', 'مدير مشروع')->exists()) {
            // Add the role "مدير المشروع" to the user's roles
            $user->roles()->attach($managerRole);
        }

        $request->session()->flash('status', 'تم تغيير مدير المشروع بنجاح');
        return redirect()->back();
    }



}
