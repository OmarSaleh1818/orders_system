<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\IndirectCosts;
use App\Models\MultiProject;
use App\Models\projects;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class PdfController extends Controller
{

    public function ProjectPdf($id)
    {

        $multi_project = MultiProject::where('project_id', $id)->get();
        $indirect_costs = IndirectCosts::where('project_id', $id)->first();
        $projects = projects::find($id);

        $data = [
            'title' => 'تسعير المشروع',
            'projects' => $projects,
            'multi_project' => $multi_project,
            'indirect_costs' => $indirect_costs,
        ];

        // Load the view content
        $view = view('pdf.project_pdf', $data)->render();

        // Create an instance of mPDF
        $mpdf = new Mpdf([
            'default_font' => 'DejaVu Sans',
            'format' => 'A4',
            'default_font_size' => 12,
            'mode' => 'utf-8',
        ]);

        // Write HTML content to PDF
        $mpdf->WriteHTML($view);

        // Output the PDF to download
        $fileName = $projects->project_name . '.pdf';
        return response()->streamDownload(function() use ($mpdf) {
            echo $mpdf->Output('', 'S');
        }, $fileName);
    }



}
