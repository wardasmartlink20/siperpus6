<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BorrowModel;
use CodeIgniter\API\ResponseTrait;
use DateTime;

class BorrowingController extends BaseController
{
    use ResponseTrait;

    protected $borrowModel;
    public function __construct()
    {
        $this->borrowModel = new BorrowModel();
    }

    public function borrowingView()
    {
        $borrowing = $this->borrowModel
            ->where('status', 'process')
            ->orWhere('status', 'borrowed')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->findAll();

        $data = [
            "data" => $borrowing,
        ];
        return view('pages/borrowing/index', $data);
    }

    public function updateBorrowingStatus($id, $status, $type)
    {
        $current = $this->borrowModel
            ->where(['borrow_id' => $id])
            ->first();

        $data = [
            "borrow_id" => $id,
            "user_id" => $current['user_id'],
            "book_id" => $current['book_id'],
            "loan_date" => $current['loan_date'],
            "due_date" => $current['due_date'],
            "status" => $status,
            "updated_at" => date('Y/m/d'),
        ];
        $this->borrowModel->replace($data);
        session()->setFlashdata('success', 'Update Status Successfully.');
        if ($type == 'borrowing') {
            return redirect()->to(base_url("/borrowing"));
        } else {
            return redirect()->to(base_url("/return"));
        }
    }

    public function returnView()
    {
        $return = $this->borrowModel
            ->where('status', 'borrowed')
            ->orWhere('status', 'done')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->findAll();

        $response = [];
        foreach ($return as $r) {
            $dueDate = new DateTime($r['due_date']);
            $currentDate = new DateTime();
            $daysDifference = $dueDate->diff($currentDate)->days;

            if ($dueDate < $currentDate) {
                $totalFine = 0;
            } else {
                $totalFine = $daysDifference * 1000;
            }

            $response[] = array_merge($r, ['total_fine' => $totalFine]);
        }

        $data = [
            "data" => $response,
        ];
        return view('pages/return/index', $data);
    }

    public function paymentView()
    {
        $return = $this->borrowModel
            ->where('status', 'done')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->findAll();

        $response = [];
        foreach ($return as $r) {
            $dueDate = new DateTime($r['due_date']);
            $currentDate = new DateTime();
            $daysDifference = $dueDate->diff($currentDate)->days;

            if ($dueDate < $currentDate) {
                $totalFine = 0;
            } else {
                $totalFine = $daysDifference * 1000;
            }

            $response[] = array_merge($r, ['total_fine' => $totalFine]);
        }

        $data = [
            "data" => $response,
        ];
        return view('pages/payment/index', $data);
    }

    public function listBorrowingApi()
    {
        $decoded = $this->decodedToken();

        $data = $this->borrowModel
            ->join('books', 'books.book_id = borrows.book_id')
            ->where(['user_id' => $decoded->user_id])
            ->findAll();

        $response = [
            'status' => 200,
            'data' => $data,
        ];

        return $this->respond($response, 200);
    }

    public function borrowingApi()
    {
        $decoded = $this->decodedToken();
        $loanDate = date('Y/m/d');
        $dueDate = date('Y/m/d', strtotime($loanDate . ' +3 days'));
        $data = [
            'user_id' => $decoded->user_id,
            'book_id' => $this->request->getVar('book_id'),
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'status' => 'process',
            'updated_at' => date('Y/m/d'),
        ];

        $this->borrowModel->save($data);
        $response = [
            "status" => 200,
            'message' => 'Borrowing Book Succesfully!',
        ];

        return $this->respond($response, 200);
    }

    public function getTotalFineApi()
    {
        $decoded = $this->decodedToken();
        $data = $this->borrowModel
            ->where([
                'borrow_id' => $this->request->getVar('borrow_id'),
                'user_id' => $decoded->user_id,
            ])
            ->first();

        $dueDate = new DateTime($data['due_date']);
        $currentDate = new DateTime();
        $daysDifference = $dueDate->diff($currentDate)->days;

        if ($dueDate < $currentDate) {
            $totalFine = 0;
        } else {
            $totalFine = $daysDifference * 1000;
        }

        $response = [
            'status' => 200,
            'data' => [
                'total_fine' => $totalFine
            ],
        ];

        return $this->respond($response, 200);
    }
}
