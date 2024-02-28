<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class PetugasController extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $totalLimit = 10;
        $offset = ($currentPage - 1) * $totalLimit;

        $userModel = new UserModel();
        $petugas = $userModel
            ->where("role", "petugas")
            ->findAll($totalLimit, $offset);

        $totalRows = $userModel
            ->where("role", "petugas")
            ->countAllResults();

        $totalPages = ceil($totalRows / $totalLimit);
        $data = [
            "data" => $petugas,
            "pager" => [
                "totalPages" => $totalPages,
                "currentPage" => $currentPage,
            ],
        ];

        return view('pages/petugas/index', $data);
    }

    public function update($id)
    {
        helper(['form']);
        $rules = [
            'user_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|min_length[4]|max_length[100]|valid_email',
            'password' => 'required|min_length[3]|max_length[50]',
            'address' => 'required',
        ];

        if ($this->validate($rules)) {
            $data = [
                'user_id' => $id,
                'user_name' => $this->request->getVar('user_name'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'address' => $this->request->getVar('address'),
                'role' => 'petugas',
                'deleted_at' => null,
            ];

            $this->userModel->replace($data);
            session()->setFlashdata('success', 'Update Petugas Successfully.');
            return redirect()->to(base_url("/petugas"));
        } else {
            $validation = Services::validation();
            return redirect()->to(base_url('/petugas'))->withInput()->with('validation', $validation);
        }
    }

    public function delete($id)
    {
        $this->userModel->where(['user_id' => $id])->delete();
        session()->setFlashdata('success', 'Delete Petugas successfully.');
        return redirect()->to(base_url('/petugas'));
    }
}
