<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected $categoryModel;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function booksView()
    {
        $categories = $this->categoryModel->findAll();
        $data = [
            "data" => $categories,
        ];
        return view('pages/category/index', $data);
    }
}
