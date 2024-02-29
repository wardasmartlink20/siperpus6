<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CollectionModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class CollectionController extends BaseController
{
    use ResponseTrait;

    protected $collectionModel;
    public function __construct()
    {
        $this->collectionModel = new CollectionModel();
    }

    public function index()
    {
        $decoded = $this->decodedToken();
        $userId = $decoded->user_id;
        $data = $this->collectionModel
            ->where("collections.user_id", $userId)
            ->join("users", "users.user_id = collections.user_id")
            ->join("books", "books.book_id = collections.book_id")
            ->findAll();

        $response = [
            'status' => 200,
            'data' => $data,
        ];

        return $this->respond($response, 200);
    }

    public function createCollection()
    {
        $decoded = $this->decodedToken();
        $userId = $decoded->user_id;

        $data = [
            "user_id" => $userId,
            "book_id" => $this->request->getVar("book_id"),
            "deleted_at" => null,
        ];

        $this->collectionModel->save($data);

        $response = [
            'status' => 200,
            'data' => "Save favorite book successfully!",
        ];

        return $this->respond($response, 200);
    }

    public function deleteCollection($id)
    {
        $this->collectionModel->where("collection_id", $id)->delete();

        $response = [
            'status' => 200,
            'data' => "Delete favorite book successfully!",
        ];

        return $this->respond($response, 200);
    }
}
