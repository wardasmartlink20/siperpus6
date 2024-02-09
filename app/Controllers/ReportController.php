<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReportModel;

class ReportController extends BaseController
{
    protected $reportModel, $reports;
    public function __construct()
    {
        $this->reportModel = new ReportModel();
        $this->reports = $this->reportModel
            ->join('payments', 'payments.payment_id = reports.payment_id')
            ->findAll();
    }

    public function reportView()
    {
        $data = [
            "data" => $this->reports
        ];
        return view("pages/report/index", $data);
    }
}
