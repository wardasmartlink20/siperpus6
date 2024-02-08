<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class BookController extends BaseController
{
    public function index()
    {
        return view('pages/buku/index');
    }
}
