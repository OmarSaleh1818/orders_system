<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\BalanceSection;
use App\Models\BalanceYear;
use App\Models\IndirectCosts;
use App\Models\Invoices;
use App\Models\projects;
use App\Models\Sections;
use App\Models\StartProject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{

    public function BalanceSettingView()
    {
        $balance = BalanceYear::orderBy('id', 'DESC')->get();
        return view('balance.balance_setting', compact('balance'));
    }

    public function AddYear()
    {
        $sections = Sections::all();
        return view('balance.add_year', compact('sections'));
    }

    public function BalanceYearStore(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'year_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'total' => 'required',
            'section_price' => 'required',
            'section_cash' => 'required',
            'section_earn' => 'required',
        ],[
            'date.required' => 'التاريخ  مطلوب',
            'year_name.required' => 'اسم السنة مطلوب',
            'start_date.required' => 'تاريخ البداية مطلوب',
            'end_date.required' => 'تاريخ النهاية مطلوب',
            'total.required' => 'المجموع مطلوب',
            'section_price' => ' المبلغ المستهدف مطلوب',
            'section_cash' => ' المبلغ المستهدف مطلوب',
            'section_earn' => ' المبلغ المستهدف مطلوب',
        ]);

        $balance_id = BalanceYear::insertGetId([
            'user_id' => Auth::user()->id,
            'date' => $request->date,
            'year_name' => $request->year_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total' => $request->total,
            'total_cash' => $request->total_cash,
            'total_earn' => $request->total_earn,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);

        $section_name = $request->section_name;
        $section_price = $request->section_price;
        $section_cash = $request->section_cash;
        $section_earn = $request->section_earn;
        foreach ($section_name as $index => $item) {
            $s_section_name = $item;
            $s_section_price = $section_price[$index];
            $s_section_cash = $section_cash[$index];
            $s_section_earn = $section_earn[$index];
            BalanceSection::insert([
                'balance_id' => $balance_id,
                'section_name' => $s_section_name,
                'section_price' => $s_section_price,
                'section_cash' => $s_section_cash,
                'section_earn' => $s_section_earn,
                'created_at' => Carbon::now(),
            ]);
        }

        Session()->flash('status', 'تم إضافة سنة مالية بنجاح');
        return redirect('/balance/setting/view');

    }

    public function BalanceYearEye($id)
    {
        $balance = BalanceYear::find($id);
        $balance_section = BalanceSection::where('balance_id', $id)->get();
        return view('balance.year_eye', compact('balance_section', 'balance'));
    }

    public function BalanceBack()
    {
        return redirect('/balance/setting/view');
    }

    public function BalanceYearEdit($id)
    {
        $balance = BalanceYear::find($id);
        $balance_section = BalanceSection::where('balance_id', $id)->get();
        return view('balance.year_edit', compact('balance_section', 'balance'));
    }

    public function BalanceYearUpdate(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'year_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'total' => 'required',
            'section_price' => 'required',
            'section_cash' => 'required',
            'section_earn' => 'required',
        ],[
            'date.required' => 'التاريخ  مطلوب',
            'year_name.required' => 'اسم السنة مطلوب',
            'start_date.required' => 'تاريخ البداية مطلوب',
            'end_date.required' => 'تاريخ النهاية مطلوب',
            'total.required' => 'المجموع مطلوب',
            'section_price' => ' المبلغ المستهدف مطلوب',
            'section_cash' => ' المبلغ المستهدف مطلوب',
            'section_earn' => ' المبلغ المستهدف مطلوب',
        ]);
         BalanceYear::findOrFail($id)->update([
            'user_id' => Auth::user()->id,
            'date' => $request->date,
            'year_name' => $request->year_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total' => $request->total,
            'total_cash' => $request->total_cash,
            'total_earn' => $request->total_earn,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);

        $Ids = $request->input('id');
        $section_name = $request->input('section_name');
        $section_price = $request->input('section_price');
        $section_cash = $request->input('section_cash');
        $section_earn = $request->input('section_earn');

// Update existing section
        foreach ($Ids as $key => $multiId) {
            $data = [
                'section_name' => $section_name[$key],
                'section_price' => $section_price[$key],
                'section_cash' => $section_cash[$key],
                'section_earn' => $section_earn[$key],
            ];
            BalanceSection::where('id', $multiId)->update($data);
        }

        Session()->flash('status', 'تم تعديل سنة مالية بنجاح');
        return redirect('/balance/setting/view');

    }

    public function BalanceProjectView()
    {
        $projects = projects::where('status_id', 13)->get();
        // Fetch the related project data
        $projectData = $projects->map(function ($project) {
            $startProject = StartProject::where('project_id', $project->id)->first();
            $totalCosts = IndirectCosts::where('project_id', $project->id)->first();
            $earnBalance = $startProject && $totalCosts ? $startProject->total - $totalCosts->before_tax : 0;
            $invoicesSum = Invoices::where('project_id', $project->id)->where('status_id', 5)->sum('total');
            $applicants = Applicant::where('project_id', $project->id)->where('status_id', 5)->sum('price');
            $sureBalance = $invoicesSum - $applicants ;
            return [
                'project_name' => $project->project_name,
                'total' => $startProject ? $startProject->total : 0,
                'total_costs' => $totalCosts ? $totalCosts->before_tax : 0,
                'earn_balance' => $earnBalance,
                'invoices' => $invoicesSum,
                'applicants' => $applicants,
                'sure_balance' => $sureBalance,
            ];
        });

        return view('balance.project_view', compact('projectData'));
    }

    public function BalancePublicView()
    {
        $balance_year = BalanceYear::all();
        $projects = projects::where('status_id', 13)->get();

        // Calculate the total for all projects
        $total = $projects->sum(function ($project) {
            return StartProject::where('project_id', $project->id)->sum('total');
        });
        $actualTotal = $projects->sum(function ($project) {
            return Invoices::where('project_id', $project->id)->where('status_id', 5)->sum('total');
        });
        $totalCosts = $projects->sum(function ($project) {
            return IndirectCosts::where('project_id', $project->id)->sum('before_tax');
        });
        $applicants = $projects->sum(function ($project) {
            return Applicant::where('project_id', $project->id)->where('status_id', 5)->sum('price');
        });
        $earnTotal = $total - $totalCosts;
        $earnActual = $actualTotal - $applicants;
        return view('balance.public_view', compact('balance_year', 'total'
            , 'actualTotal', 'totalCosts', 'applicants', 'earnTotal', 'earnActual'));
    }


}
