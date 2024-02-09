<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaymentModel;
use CodeIgniter\HTTP\ResponseInterface;

class PaymentController extends BaseController
{
    protected $paymentModel, $payments;
    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->payments = $this->paymentModel
            ->join('borrows', 'borrows.borrow_id = payments.borrow_id')
            ->findAll();
    }

    public function paymentView()
    {
        $data = [
            "data" => $this->payments
        ];
        return view("pages/payment/index", $data);
    }
}
