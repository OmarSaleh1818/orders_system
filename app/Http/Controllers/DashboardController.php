<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function Dashboard() {

        $orders = Applicant::all()->count();
        $reject = Applicant::where('status_id', 2)->orWhere('status_id', 12)->count();
        $wait = Applicant::where('status_id', 1)->orWhere('status_id', 3)->orWhere('status_id', 4)
            ->orWhere('status_id', 8)->orWhere('status_id', 9)->orWhere('status_id', 10)->orWhere('status_id', 11)->count();
        $done = Applicant::where('status_id', 5)->count();

        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['المشاريع المعتمدة', 'المشاريع الغير معتمدة', 'المشاريع في الانتظار'])
            ->datasets([
                [
                    "label" => "My First dataset",
                    'backgroundColor' => ['rgba(0,128,0)', 'rgba(255,0,0)', 'rgba(128,128,128)'],
                    'data' => [50, 59, 40]
                ],
                [
                    "label" => "My First dataset",
                    'backgroundColor' => ['rgba(255, 99, 132, 0.3)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [65, 12]
                ]
            ])
            ->options([]);
        $chartjs1 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['المشاريع المعتمدة', ' المشاريع الغير معتمدة'])
            ->datasets([
                [
                    'backgroundColor' => ['#DDD', '#36A2EB'],
                    'hoverBackgroundColor' => ['#DDD', '#36A2EB'],
                    'data' => [69, 59]
                ]
            ])
            ->options([]);
        return view('dashboard', compact('orders', 'reject', 'wait', 'done', 'chartjs', 'chartjs1'));
    }



}
