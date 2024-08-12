<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\OpenProjectReject;
use App\Models\project_users;
use App\Models\projects;
use App\Models\OpenProject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OpenPrejectController extends Controller
{

    public function ProjectOpenView() {

        $openProject = OpenProject::orderBy('id','DESC')->get();
        return view('project.project_open' , compact('openProject'));
    }

    public function AddProjectOpen($id) {

        $users = User::all();
        $projects = projects::where('id', $id)->first();
        $section_name = $projects->section_name;
        $sectionLetterMap = [
            'نديم' => 'N',
            'بناء الطاقات' => 'B',
            'الكفاءة الاستراتيجية' => 'F',
            'إعلامك' => 'E',
            'الطرق الأربعة' => 'T',
            'خبراء الشباب' => 'K',
        ];
// Assuming $section_name contains the section name for the current project
        $letter = $sectionLetterMap[$section_name];
        $lastProjectCode = DB::table('open_projects')->orderBy('id', 'desc')->value('project_code');
        if ($lastProjectCode) {
            $parts = explode('-', $lastProjectCode);
            $numericPart = intval($parts[1]);
            $newNumericPart = str_pad($numericPart + 1, 3, '0', STR_PAD_LEFT);
            $newProjectCode = $letter . '-' . $newNumericPart . '-' . $parts[2];
        } else {
            // Handle the case where $lastProjectCode is empty (e.g., first project)
            $newProjectCode = $letter . '-001-24';
        }
        return view('project.add_project_open' , compact('projects', 'users', 'newProjectCode'));
    }

    public function ProjectOpenStore(Request $request,$id) {

        $request->validate([
            'date' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'art_show' => 'required|mimes:pdf,doc,docx|max:2024',
            'finance_show' => 'required|mimes:pdf,doc,docx|max:2024',
            'draft_show' => 'required|mimes:pdf,doc,docx|max:2024',
            'user_name' => 'required'
        ],[
            'date.required' => 'التاريخ مطلوب',
            'start_date.required' => 'تاريخ بداية المشروع مطلوب',
            'end_date.required' => 'تاريخ نهاية المشروع مطلوب',
            'art_show.required' => 'إرفاق العرض الفني مطلوب',
            'art_show.mimes' => 'يجب أن يكون الملف من نوع PDF أو DOC',
            'finance_show.required' => 'إرفاق العرض المالي مطلوب',
            'finance_show.mimes' => 'يجب أن يكون الملف من نوع PDF أو DOC',
            'draft_show.required' => 'إرفاق مسودة العرض الفني مطلوب',
            'draft_show.mimes' => 'يجب أن يكون الملف من نوع PDF أو DOC',
            'user_name.required' => 'اختيار الموظفين مطلوب'
        ]);

        $user_id = Auth::user()->id;

        $art_show = $request->file('art_show');
        $originalArtShow = $art_show->getClientOriginalName();
        $sanitizedFileArtShow = Str::slug(pathinfo($originalArtShow, PATHINFO_FILENAME), '_') . '.' . $art_show->getClientOriginalExtension();
        $art_showPath = $art_show->move("upload", $sanitizedFileArtShow);

        $finance_show = $request->file('finance_show');
        $originalFinanceShow = $finance_show->getClientOriginalName();
        $sanitizedFileFinanceShow = Str::slug(pathinfo($originalFinanceShow, PATHINFO_FILENAME), '_') . '.' . $finance_show->getClientOriginalExtension();
        $finance_showPath = $finance_show->move("upload", $sanitizedFileFinanceShow);

        $draft_show = $request->file('draft_show');
        $originalDraftShow = $draft_show->getClientOriginalName();
        $sanitizedFileDraftShow = Str::slug(pathinfo($originalDraftShow, PATHINFO_FILENAME), '_') . '.' . $draft_show->getClientOriginalExtension();
        $draft_showPath = $draft_show->move("upload", $sanitizedFileDraftShow);

        if($art_showPath && $finance_showPath && $finance_showPath) {
            $open_project = OpenProject::insertGetId([
                'user_id' => $user_id,
                'project_id' => $id,
                'date' => $request->date,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'project_days' => $request->project_days,
                'customer_type' => $request->customer_type,
                'customer_name' => $request->customer_name,
                'benefit' => $request->benefit,
                'project_code' => $request->project_code,
                'art_show' => $art_showPath,
                'finance_show' => $finance_showPath,
                'draft_show' => $draft_showPath,
                'description' => $request->description,
                'created_at' => Carbon::now(),
            ]);

            $user_name = $request->input('user_name');
            foreach ($user_name as $user) {
                project_users::insert([
                    'project_id' => $id,
                    'openProject_id' => $open_project,
                    'user_name' => $user,
                    'created_at' => Carbon::now(),
                ]);
            }
            DB::table('projects')
                ->where('id', $id)
                ->update([
                    'status_id' => 3,
                    'project_code' => $request->project_code
                ]);

            $request->session()->flash('status', 'تم فتح مشروع بنجاح');
            return redirect('/project/open/view');
        } else {
            Session()->flash('status', 'للأسف لم يتم ');
            return redirect('/project/open/view');
        }
    }

    public function ProjectManagerEye($id) {
        $project_users = project_users::where('openProject_id', $id)->get();
        $openProject = OpenProject::find($id);
        return view('project.manager_eye', compact('openProject', 'project_users'));
    }

    public function OpenProjectBack() {

        return redirect('/project/open/view');
    }

    public function OpenProjectReject(Request $request , $id) {

            $request->validate([
                'reject_reason'=> 'required'
            ],[
                'reject_reason.required' => 'السبب مطلوب'
            ]);
            $existingRecord = OpenProjectReject::where('openProject_id', $id)->first();
            if ($existingRecord) {
                $existingRecord->update([
                    'reject_reason' => $request->reject_reason,
                    'created_at' => Carbon::now(),
                ]);
            } else {
                OpenProjectReject::insert([
                    'openProject_id' => $id,
                    'reject_reason' => $request->reject_reason,
                    'created_at' => Carbon::now(),
                ]);
            }
            DB::table('open_projects')
                ->where('id', $id)
                ->update(['status_id' => 2]);
            Session()->flash('status', 'لم يتم اعتماد فتح المشروع ');
            return redirect('/project/open/view');

    }

    public function OpenProjectEdit($id) {

        $project_users = project_users::where('openProject_id', $id)->get();
        $openProject = OpenProject::find($id);
        $openProjectReject = OpenProjectReject::where('openProject_id', $id)->first();
        return view('project.open_project_edit', compact('openProject',
                'project_users', 'openProjectReject'));
    }

    public function OpenProjectUpdate(Request $request, $id) {
        $request->validate([
            'date' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'user_name' => 'required'
        ],[
            'date.required' => 'التاريخ مطلوب',
            'start_date.required' => 'تاريخ بداية المشروع مطلوب',
            'end_date.required' => 'تاريخ نهاية المشروع مطلوب',
            'user_name.required' => 'اختيار الموظفين مطلوب'
        ]);

        if ($request->hasFile('art_show')) {
            $art_show = $request->file('art_show');
            $originalArtShow = $art_show->getClientOriginalName();
            $sanitizedFileArtShow = Str::slug(pathinfo($originalArtShow, PATHINFO_FILENAME), '_') . '.' . $art_show->getClientOriginalExtension();
            $art_showPath = $art_show->move("upload", $sanitizedFileArtShow);
            OpenProject::findOrFail($id)->update([
                'art_show' => $art_showPath,
            ]);
        }

        if ($request->hasFile('finance_show')) {
            $finance_show = $request->file('finance_show');
            $originalFinanceShow = $finance_show->getClientOriginalName();
            $sanitizedFileFinanceShow = Str::slug(pathinfo($originalFinanceShow, PATHINFO_FILENAME), '_') . '.' . $finance_show->getClientOriginalExtension();
            $finance_showPath = $finance_show->move("upload", $sanitizedFileFinanceShow);
            OpenProject::findOrFail($id)->update([
                'finance_show' => $finance_showPath,
            ]);
        }

        if ($request->hasFile('draft_show')) {
            $draft_show = $request->file('draft_show');
            $originalDraftShow = $draft_show->getClientOriginalName();
            $sanitizedFileDraftShow = Str::slug(pathinfo($originalDraftShow, PATHINFO_FILENAME), '_') . '.' . $draft_show->getClientOriginalExtension();
            $draft_showPath = $draft_show->move("upload", $sanitizedFileDraftShow);
            OpenProject::findOrFail($id)->update([
                'draft_show' => $draft_showPath,
            ]);
        }

        OpenProject::findOrFail($id)->update([
            'date' => $request->date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project_days' => $request->project_days,
            'customer_type' => $request->customer_type,
            'customer_name' => $request->customer_name,
            'benefit' => $request->benefit,
            'project_code' => $request->project_code,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);

        $user_names = $request->input('user_name');
        if (!empty($user_names)) {
            foreach ($user_names as $user_name) {
                $existingUser = project_users::where('openProject_id', $id)->where('user_name', $user_name)->first();
                if ($existingUser) {

                    $data = ['user_name' => $user_name];
                    project_users::where('id', $existingUser->id)->update($data);
                } else {

                    project_users::create([
                        'project_id' => $request->project_id,
                        'openProject_id' => $id,
                        'user_name' => $user_name
                    ]);
                }
            }
        }

        DB::table('open_projects')
            ->where('id', $id)
            ->update(['status_id' => 1]);

        $request->session()->flash('status', 'تم التعديل  بنجاح');
        return redirect('/project/open/view');

    }

    public function OpenProjectSure($id) {
        DB::table('open_projects')
            ->where('id', $id)
            ->update(['status_id' => 3]);
        Session()->flash('status', 'تم الاعتماد بنجاح');
        return redirect('/project/open/view');
    }

    public function OpenProjectManagerSure($id) {
        DB::table('open_projects')
            ->where('id', $id)
            ->update(['status_id' => 6]);
        Session()->flash('status', 'تم الاعتماد بنجاح');
        return redirect('/project/open/view');
    }


}
