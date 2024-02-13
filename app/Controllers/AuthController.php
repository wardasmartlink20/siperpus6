<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
    use ResponseTrait;
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
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

        $data = $userModel
            ->where('role !=', 'user')
            ->where('email', $email)->first();

        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $ses_data = [
                    'user_id' => $data['user_id'],
                    'user_name' => $data['user_name'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                    'is_logged_in' => TRUE
                ];

                $session->set($ses_data);

                if ($data['role'] == 'admin') {
                    return redirect()->to(base_url('/books'));
                } else {
                    return redirect()->to(base_url('/borrowing'));
                }
            } else {
                $session->setFlashdata('failed', 'Password is incorrect.');
                return redirect()->to(base_url('/login'));
            }
        } else {
            $session->setFlashdata('failed', 'Email does not exist.');
            return redirect()->to(base_url('/login'));
        }
    }

    public function loginApi()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $this->userModel->where('email', $email)->first();

        if (is_null($user)) {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        }

        $pwd_verify = password_verify($password, $user['password']);

        if (!$pwd_verify) {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        }

        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;

        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "user_id" => $user['user_id'],
            "user_name" => $user['user_name'],
            "email" => $user['email'],
            "role" => $user['role'],
        );

        $token = JWT::encode($payload, $key, 'HS256');

        $response = [
            'status' => 200,
            'message' => 'Login Succesfully!',
            'data' => [
                'token' => $token,
            ]
        ];

        return $this->respond($response, 200);
    }

    public function registerView()
    {
        return view('pages/auth/register');
    }

    public function registerAuth()
    {
        helper(['form']);
        $rules = [
            'user_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[3]|max_length[50]',
            'address' => 'required',
        ];

        $isPetugas = $this->request->getVar('redirectTo') === "petugas";
        if ($this->validate($rules)) {
            $data = [
                'user_name' => $this->request->getVar('user_name'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'address' => $this->request->getVar('address'),
                'role' => 'petugas',
            ];

            $this->userModel->save($data);
            session()->setFlashdata('success', 'Registration Successfully.');
            if ($isPetugas) {
                return redirect()->to(base_url("/petugas"));
            } else {
                return redirect()->to(base_url("/login"));
            }
        } else {
            $validation = Services::validation();
            if ($isPetugas) {
                return redirect()->to(base_url('/petugas'))->withInput()->with('validation', $validation);
            } else {
                return redirect()->to(base_url('/register'))->withInput()->with('validation', $validation);
            }
        }
    }

    public function registerApi()
    {
        helper(['form']);
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
                'role' => 'user',
            ];

            $this->userModel->save($data);
            $response = [
                "status" => 200,
                'message' => 'Registration Succesfully!',
            ];

            return $this->respond($response, 200);
        } else {
            $response = [
                "status" => 404,
                'message' => 'Bad Request!',
            ];
            return $this->respond($response, 404);
        }
    }

    public function profileAPi()
    {
        $decoded = $this->decodedToken();

        $modelProfile = new UserModel();
        $data = $modelProfile
            ->where(['user_id' => $decoded->user_id])
            ->first();

        $finalData = array_diff_key($data, ['password' => '']);

        $response = [
            "status" => 200,
            "data" => $finalData,
        ];

        return $this->respond($response, 200);
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
