<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReviewModel;
use CodeIgniter\API\ResponseTrait;

class ReviewController extends BaseController
{
    use ResponseTrait;

    protected $reviewModel;
    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }

    public function listReviewApi()
    {
        $responseData = $this->reviewModel->findAll();
        $response = [
            "status" => 200,
            "data" => $responseData,
        ];

        return $this->respond($response, 200);
    }

    public function submitReviewApi()
    {
        $decoded = $this->decodedToken();
        $data = [
            'user_id' => $decoded->user_id,
            'book_id' => $this->request->getVar('book_id'),
            'review' => $this->request->getVar('review'),
            'rating' => $this->request->getVar('rating'),
            'deleted_at' => null,
        ];

        $this->reviewModel->save($data);
        $response = [
            "status" => 200,
            'message' => 'Submit Review Succesfully!',
        ];

        return $this->respond($response, 200);
    }
}
