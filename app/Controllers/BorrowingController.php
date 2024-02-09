<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BorrowModel;

class BorrowingController extends BaseController
{
    protected $borrowModel, $borrowing;
    public function __construct()
    {
        $this->borrowModel = new BorrowModel();
        $this->borrowing = $this->borrowModel
            ->join('users', 'users.user_id = borrows.user_id')
            ->join('books', 'books.book_id = borrows.book_id')
            ->findAll();
    }

    public function borrowingView()
    {
        $data = [
            "data" => $this->borrowing,
        ];
        return view('pages/borrowing/index', $data);
    }

    public function returnView()
    {
        $data = [
            "data" => $this->borrowing,
        ];
        return view('pages/return/index', $data);
    }
}
