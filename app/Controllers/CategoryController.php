<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class CategoryController extends BaseController
{
    use ResponseTrait;
    protected $categoryModel;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $totalLimit = 10;
        $offset = ($currentPage - 1) * $totalLimit;

        $categories = $this->categoryModel->findAll($totalLimit, $offset);
        $totalRows = $this->categoryModel->countAllResults();
        $totalPages = ceil($totalRows / $totalLimit);

        $data = [
            "data" => $categories,
            "pager" => [
                "totalPages" => $totalPages,
                "currentPage" => $currentPage,
                "limit" => $totalLimit,
            ],
        ];
        return view('pages/category/index', $data);
    }

    public function create()
    {
        helper(['form']);
        $rules = [
            'category_name' => 'required|min_length[2]|max_length[50]',
        ];

        if ($this->validate($rules)) {
            $data = [
                'category_name' => $this->request->getVar('category_name'),
                'deleted_at' => null,
            ];

            $this->categoryModel->save($data);
            session()->setFlashdata('success', 'Add Book Category Successfully.');
            return redirect()->to(base_url("/category"));
        } else {
            $validation = Services::validation();
            return redirect()->to(base_url('/category'))->withInput()->with('validation', $validation);
        }
    }

    public function update($id)
    {
        helper(['form']);
        $rules = [
            'category_name' => 'required|min_length[2]|max_length[50]',
        ];

        if ($this->validate($rules)) {
            $data = [
                'category_id' => $id,
                'category_name' => $this->request->getVar('category_name'),
                'deleted_at' => null,
            ];

            $this->categoryModel->replace($data);
            session()->setFlashdata('success', 'Update Book Category Successfully.');
            return redirect()->to(base_url("/category"));
        } else {
            $validation = Services::validation();
            return redirect()->to(base_url('/category'))->withInput()->with('validation', $validation);
        }
    }

    public function delete($id)
    {
        $this->categoryModel->where(['category_id' => $id])->delete();
        session()->setFlashdata('success', 'Delete Book Category successfully.');
        return redirect()->to(base_url('/category'));
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
