<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\IndirectCosts;
use App\Models\MultiProject;
use App\Models\MultiStartProject;
use App\Models\MultiStep;
use App\Models\OpenProject;
use App\Models\project_users;
use App\Models\ProjectAprrovedReject;
use App\Models\projects;
use App\Models\StartProject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StartProjectControler extends Controller
{

    public function AddProjectStart($id) {

        $openProject = OpenProject::where('id', $id)->first();
        return view('project.add_project_start', compact('openProject'));
    }

    public function ProjectStartStore(Request $request, $id) {

        $request->validate([
            'date' => 'required',
            'batch_value' => 'required',
            'art_show' => 'required|mimes:pdf,doc,docx|max:2024',
            'finance_show' => 'required|mimes:pdf,doc,docx|max:2024',
            'draft_show' => 'required|mimes:pdf,doc,docx|max:2024',
        ],[
            'date.required' => 'التاريخ مطلوب',
            'art_show.required' => 'إرفاق العرض الفني مطلوب',
            'art_show.mimes' => 'يجب أن يكون الملف من نوع PDF أو DOC',
            'finance_show.required' => 'إرفاق العرض المالي مطلوب',
            'finance_show.mimes' => 'يجب أن يكون الملف من نوع PDF أو DOC',
            'draft_show.required' => 'إرفاق مسودة العرض الفني مطلوب',
            'draft_show.mimes' => 'يجب أن يكون الملف من نوع PDF أو DOC',
        ]);

        $art_show = $request->file('art_show');
        $art_showPath = $art_show->move("upload", $art_show->getClientOriginalName());
        $finance_show = $request->file('finance_show');
        $finance_showPath = $finance_show->move("upload", $finance_show->getClientOriginalName());
        $draft_show = $request->file('draft_show');
        $draft_showPath = $draft_show->move("upload", $draft_show->getClientOriginalName());

        if($art_showPath && $finance_showPath && $finance_showPath) {
            $start_project = StartProject::insertGetId([
                'project_id' => $request->project_id,
                'openProject_id' => $id,
                'date' => $request->date,
                'total' => $request->total,
                'art_show' => $art_showPath,
                'finance_show' => $finance_showPath,
                'draft_show' => $draft_showPath,
                'description' => $request->description,
                'created_at' => Carbon::now(),
            ]);
            $batch_number = $request->batch_number;
            $batch_value = $request->batch_value;
            $due_date = $request->due_date;
            foreach ($batch_number as $index => $batch) {
                $s_number = $batch;
                $s_value = $batch_value[$index];
                $s_date = $due_date[$index];
                MultiStartProject::insert([
                    'project_id' => $request->project_id,
                    'startProject_id' => $start_project,
                    'batch_number' => $s_number,
                    'batch_value' => $s_value,
                    'due_date' => $s_date
                ]);
            }
            DB::table('open_projects')
                ->where('id', $id)
                ->update(['status_id' => 4]);

            $request->session()->flash('status', 'تم إرسال بدء المشروع بنجاح');
            return redirect('/project/open/view');
        } else {
            Session()->flash('status', 'للأسف لم يتم ');
            return redirect('/project/open/view');
        }

    }

    public function ProjectApprovedEye($id) {

        $openProject = OpenProject::find($id);
        $project = projects::where('id', $openProject->project_id)->first();
        $steps = MultiStep::where('project_id', $openProject->project_id)->get();
        $multi_project = MultiProject::where('project_id', $openProject->project_id)->get();
        $indirect_costs = IndirectCosts::where('project_id', $openProject->project_id)->first();
        $project_users = project_users::where('openProject_id', $id)->get();
        $start_project = StartProject::where('openProject_id', $id)->first();
        $users = User::all();
        $batch = $start_project->id;
        $multi_batch = MultiStartProject::where('startProject_id', $batch)->get();
        return view('project.project_approved', compact('openProject',
            'project', 'steps', 'multi_project', 'project_users',
                       'indirect_costs', 'start_project', 'multi_batch', 'users'));
    }

    public function ProjectApprovedReject(Request $request, $id) {

        $request->validate([
            'reject_reason'=> 'required'
        ],[
            'reject_reason.required' => 'السبب مطلوب'
        ]);

        $existingRecord = ProjectAprrovedReject::where('openProject_id', $id)->first();
        if ($existingRecord) {
            $existingRecord->update([
                'reject_reason' => $request->reject_reason,
                'created_at' => Carbon::now(),
            ]);
        } else {
            ProjectAprrovedReject::insert([
                'openProject_id' => $id,
                'reject_reason' => $request->reject_reason,
                'created_at' => Carbon::now(),
            ]);
        }

        DB::table('open_projects')
            ->where('id', $id)
            ->update(['status_id' => 12]);
        Session()->flash('status', 'لم يتم اعتماد المشروع ');
        return redirect('/project/open/view');
    }

    public function ProjectApprovedEdit($id) {
        $openProject = OpenProject::find($id);
        $start_project = StartProject::where('openProject_id', $openProject->id)->first();
        $batch = $start_project->id;
        $multi_batch = MultiStartProject::where('startProject_id', $batch)->get();
        $projectApprovedReject = ProjectAprrovedReject::where('openProject_id', $id)->first();

        return view('project.project_approved_edit', compact('start_project',
               'multi_batch', 'openProject', 'projectApprovedReject'));
    }

    public function ProjectApprovedUpdate(Request $request, $id) {
        $openProject = OpenProject::find($id);
        if ($request->hasFile('art_show')) {
            $art_show = $request->file('art_show');
            $art_showPath = $art_show->move("upload", $art_show->getClientOriginalName());
            StartProject::where('openProject_id', $openProject->id)->update([
                'art_show' => $art_showPath,
            ]);
        }
        if ($request->hasFile('finance_show')) {
            $finance_show = $request->file('finance_show');
            $finance_showPath = $finance_show->move("upload", $finance_show->getClientOriginalName());
            OpenProject::where('openProject_id', $openProject->id)->update([
                'finance_show' => $finance_showPath,
            ]);
        }
        if ($request->hasFile('draft_show')) {
            $draft_show = $request->file('draft_show');
            $draft_showPath = $draft_show->move("upload", $draft_show->getClientOriginalName());
            OpenProject::where('openProject_id', $openProject->id)->update([
                'draft_show' => $draft_showPath,
            ]);
        }
        StartProject::where('openProject_id', $openProject->id)->update([
            'date' => $request->date,
            'total' => $request->total,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);

        $multiIds = $request->input('multi');
        $batch_number = $request->input('batch_number');
        $batch_value = $request->input('batch_value');
        $due_date = $request->input('due_date');
        foreach ($multiIds as $key => $multiId) {
            $data = [
                'batch_number' => $batch_number[$key],
                'batch_value' => $batch_value[$key],
                'due_date' => $due_date[$key],
            ];
            MultiStartProject::where('id', $multiId)->update($data);
        }

        DB::table('open_projects')
            ->where('id', $id)
            ->update(['status_id' => 4]);

        $request->session()->flash('status', 'تم التعديل  بنجاح');
        return redirect('/project/open/view');

    }

    public function ProjectApprovedSure($id) {

        DB::table('open_projects')
            ->where('id', $id)
            ->update(['status_id' => 5]);
        Session()->flash('status', 'تم الاعتماد بنجاح');
        return redirect('/project/open/view');
    }

    public function ProjectApprovedManagerSure($id) {

        $openProject = OpenProject::find($id);
        DB::table('open_projects')
            ->where('id', $id)
            ->update(['status_id' => 13]);

        DB::table('projects')
            ->where('id', $openProject->project_id)
            ->update(['status_id' => 13]);
        Session()->flash('status', 'تم الاعتماد بنجاح');
        return redirect('/project/open/view');
    }



}
