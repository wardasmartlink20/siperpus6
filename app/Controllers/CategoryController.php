<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;

class CategoryController extends BaseController
{
    use ResponseTrait;
    protected $categoryModel;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function categoryView()
    {
        $categories = $this->categoryModel->findAll();
        $data = [
            "data" => $categories,
        ];
        return view('pages/category/index', $data);
    }

    public function categoryApi()
    {
        $categories = $this->categoryModel->findAll();
        $response = [
            "status" => 200,
            "data" => $categories,
        ];

        return $this->respond($response, 200);
    }
}
