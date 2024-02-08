<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class AuthController extends BaseController
{
    public function loginView()
    {
        return view('pages/auth/login');
    }

    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $userModel->where('email', $email)->first();
        // dd($data);

        if ($data) {
            $pass = $data['password'];
            // dd($pass);
            $authenticatePassword = password_verify($password, $pass);
            // dd($authenticatePassword);
            if ($authenticatePassword) {
                $ses_data = [
                    'user_id' => $data['user_id'],
                    'user_name' => $data['user_name'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                    'is_logged_in' => TRUE
                ];

                $session->set($ses_data);

                return redirect()->to(base_url('/books'));
            } else {
                $session->setFlashdata('failed', 'Password is incorrect.');
                return redirect()->to(base_url('/login'));
            }
        } else {
            $session->setFlashdata('failed', 'Email does not exist.');
            return redirect()->to(base_url('/login'));
        }
    }

    public function registerView()
    {
        return view('pages/auth/register');
    }

    public function registerAuth()
    {
        helper(['form']);
        $userModel = new UserModel();

        $rules = [
            'user_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[3]|max_length[50]',
            'address' => 'required',
        ];

        if ($this->validate($rules)) {
            $data = [
                'user_name' => $this->request->getVar('user_name'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'address' => $this->request->getVar('address'),
                'role' => 'petugas',
            ];

            $userModel->save($data);
            session()->setFlashdata('success', 'Registration Successfully.');
            return redirect()->to(base_url("/login"));
        } else {
            $validation = Services::validation();
            return redirect()->to(base_url('/register'))->withInput()->with('validation', $validation);
        }
    }

    function logout()
    {
        $session = session();
        $session->set(array(
            'user_id' => '',
            'user_name' => '',
            'email' => '',
            'role' => '',
            'is_logged_in' => FALSE
        ));
        $session->destroy();
        return redirect()->to(base_url('/login'));
    }
}
