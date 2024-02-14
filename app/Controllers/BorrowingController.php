<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BorrowModel;
use CodeIgniter\API\ResponseTrait;
use DateTime;
use Dompdf\Dompdf;

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
        $currentPage = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $totalLimit = 10;
        $offset = ($currentPage - 1) * $totalLimit;

        $borrowing = $this->borrowModel
            ->where('status', 'process_borrowing')
            ->orWhere('status', 'borrowed')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->findAll($totalLimit, $offset);

        $totalRows = $this->borrowModel
            ->where('status', 'process_borrowing')
            ->orWhere('status', 'borrowed')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->countAllResults();

        $totalPages = ceil($totalRows / $totalLimit);
        $data = [
            "data" => $borrowing,
            "pager" => [
                "totalPages" => $totalPages,
                "currentPage" => $currentPage,
                "limit" => $totalLimit,
            ],
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
        $currentPage = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $totalLimit = 10;
        $offset = ($currentPage - 1) * $totalLimit;

        $return = $this->borrowModel
            ->where('status', 'process_return')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->findAll($totalLimit, $offset);

        $totalRows = $this->borrowModel
            ->where('status', 'process_return')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->countAllResults();

        $totalPages = ceil($totalRows / $totalLimit);

        $response = [];
        foreach ($return as $r) {
            $dueDate = new DateTime($r['due_date']);
            $currentDate = new DateTime();
            $daysDifference = $dueDate->diff($currentDate)->days;
            if ($dueDate >= $currentDate) {
                $totalFine = 0;
            } else {
                $totalFine = $daysDifference * 1000;
            }

            $response[] = array_merge($r, ['total_fine' => $totalFine]);
        }

        $data = [
            "data" => $response,
            "pager" => [
                "totalPages" => $totalPages,
                "currentPage" => $currentPage,
                "limit" => $totalLimit,
            ],
        ];
        return view('pages/return/index', $data);
    }

    public function paymentView()
    {
        $currentPage = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $totalLimit = 10;
        $offset = ($currentPage - 1) * $totalLimit;
        $return = $this->borrowModel
            ->where('status', 'done')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->findAll($totalLimit, $offset);

        $totalRows = $this->borrowModel
            ->where('status', 'done')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->countAllResults();

        $totalPages = ceil($totalRows / $totalLimit);
        $response = [];
        foreach ($return as $r) {
            $dueDate = new DateTime($r['due_date']);
            $updatedAt = new DateTime($r['updated_at']);
            $daysDifference = $dueDate->diff($updatedAt)->days;

            if ($dueDate >= $updatedAt) {
                $totalFine = 0;
            } else {
                $totalFine = $daysDifference * 1000;
            }

            $response[] = array_merge($r, ['total_fine' => $totalFine]);
        }

        $data = [
            "data" => $response,
            "pager" => [
                "totalPages" => $totalPages,
                "currentPage" => $currentPage,
                "limit" => $totalLimit,
            ],
        ];
        return view('pages/payment/index', $data);
    }

    public function reportView()
    {
        $date = $this->request->getVar('date');
        $currentPage = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $totalLimit = 10;
        $offset = ($currentPage - 1) * $totalLimit;
        $query = $this->borrowModel
            ->select('borrows.*, users.user_name, books.title')
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->where('status', 'done');

        $return = [];
        if ($date) {
            $return = $query
                ->where('DATE(loan_date)', $date)
                ->findAll($totalLimit, $offset);
        } else {
            $return = $query->findAll($totalLimit, $offset);
        }

        $totalRows = 0;
        if ($date) {
            $totalRows = $this->borrowModel
                ->select('borrows.*, users.user_name, books.title')
                ->join('users', 'users.user_id = borrows.user_id')
                ->join('books', 'books.book_id = borrows.book_id')
                ->where('status', 'done')
                ->where('DATE(loan_date)', $date)
                ->countAllResults();
        } else {
            $totalRows = $this->borrowModel
                ->select('borrows.*, users.user_name, books.title')
                ->join('users', 'users.user_id = borrows.user_id')
                ->join('books', 'books.book_id = borrows.book_id')
                ->where('status', 'done')
                ->countAllResults();
        }

        $totalPages = ceil($totalRows / $totalLimit);

        $response = [];
        foreach ($return as $r) {
            $dueDate = new DateTime($r['due_date']);
            $currentDate = new DateTime();
            $daysDifference = $dueDate->diff($currentDate)->days;

            if ($dueDate >= $currentDate) {
                $totalFine = 0;
            } else {
                $totalFine = $daysDifference * 1000;
            }

            $response[] = array_merge($r, ['total_fine' => $totalFine]);
        }

        $data = [
            "data" => $response,
            "pager" => [
                "totalPages" => $totalPages,
                "currentPage" => $currentPage,
                "limit" => $totalLimit,
            ],
        ];

        return view('pages/report/index', $data);
    }

    public function generate()
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

            if ($dueDate >= $currentDate) {
                $totalFine = 0;
            } else {
                $totalFine = $daysDifference * 1000;
            }

            $response[] = array_merge($r, ['total_fine' => $totalFine]);
        }

        $data = [
            "data" => $response,
        ];

        $filename = date('y-m-d-H-i-s') . '-report';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        // load HTML content
        $dompdf->loadHtml(view('pages/report/template_report', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function listBorrowingApi()
    {
        $decoded = $this->decodedToken();

        $data = $this->borrowModel
            ->join('books', 'books.book_id = borrows.book_id')
            ->where(['user_id' => $decoded->user_id])
            ->findAll();

        $response = [];

        foreach ($data as $d) {
            $dueDate = new DateTime($d['due_date']);
            $currentDate = new DateTime();
            $daysDifference = $dueDate->diff($currentDate)->days;

            if ($dueDate > $currentDate) {
                $totalFine = 0;
            } else {
                $totalFine = $daysDifference * 1000;
            }

            $response[] = array_merge($d, ['total_fine' => $totalFine]);
        }

        $response = [
            'status' => 200,
            'data' => $response,
        ];

        return $this->respond($response, 200);
    }

    public function postBorrowingBook()
    {
        $decoded = $this->decodedToken();
        $loanDate = date('Y/m/d');
        $dueDate = date('Y/m/d', strtotime($loanDate . ' +3 days'));
        $data = [
            'user_id' => $decoded->user_id,
            'book_id' => $this->request->getVar('book_id'),
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'status' => 'process_borrowing',
            'updated_at' => date('Y/m/d'),
        ];

        $this->borrowModel->save($data);
        $response = [
            "status" => 200,
            'message' => 'Borrowing Book Succesfully!',
        ];

        return $this->respond($response, 200);
    }

    public function postReturnBook()
    {
        $decoded = $this->decodedToken();
        $borrowId =  $this->request->getVar('borrow_id');
        $currentBook = $this->borrowModel->where("borrow_id", $borrowId)->first();
        $loanDate = date('Y/m/d');
        $dueDate = date('Y/m/d', strtotime($loanDate . ' +3 days'));
        $data = [
            'borrow_id' => $borrowId,
            'user_id' => $decoded->user_id,
            'book_id' => $currentBook['book_id'],
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'status' => 'process_return',
            'updated_at' => date('Y/m/d'),
        ];

        $this->borrowModel->replace($data);
        $response = [
            "status" => 200,
            'message' => 'Return Book Succesfully!',
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
