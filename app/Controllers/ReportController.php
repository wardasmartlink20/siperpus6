<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReportModel;
use Dompdf\Dompdf;

class ReportController extends BaseController
{
    protected $reportModel, $reports;
    public function __construct()
    {
        $this->reportModel = new ReportModel();
        $this->reports = $this->reportModel
            ->join('borrows', 'borrows.borrow_id = reports.borrow_id')
            ->findAll();
    }

    public function generate()
    {
        $filename = date('y-m-d-H-i-s') . '-qadr-labs-report';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('pages/report/index'));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }
}
