<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CollectionModel;
use App\Models\ReviewModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class CollectionController extends BaseController
{
    use ResponseTrait;

    protected $collectionModel, $reviewModel;
    public function __construct()
    {
        $this->collectionModel = new CollectionModel();
        $this->reviewModel = new ReviewModel();
    }

    public function index()
    {
        $decoded = $this->decodedToken();
        $userId = $decoded->user_id;
        $books = $this->collectionModel
            ->where("collections.user_id", $userId)
            ->join("users", "users.user_id = collections.user_id")
            ->join("books", "books.book_id = collections.book_id")
            ->findAll();

        $responseData = [];
        foreach ($books as $book) {
            $collection = $this->collectionModel
                ->where("user_id", $userId)
                ->where("book_id", $book["book_id"])
                ->first();
            $statusCollection = boolval($collection);

            $reviews = $this->reviewModel
                ->join('users', 'users.user_id = reviews.user_id')
                ->where(['book_id' => $book['book_id']])
                ->findAll();

            $totalRating = 0;
            $responseReview = [];
            foreach ($reviews as $review) {
                $totalRating += (int)$review['rating'];
                $responseReview[] = [
                    'review_id' => $review['review_id'],
                    'user_name' => $review['user_name'],
                    'review' => $review['review'],
                    'rating' => (int)$review['rating'],
                ];
            }

            $averageRating = count($reviews) > 0 ? $totalRating / count($reviews) : 0;

            $responseData[] = array_merge($book, [
                'is_save' => $statusCollection,
                'rating' => round($averageRating, 1),
                'reviews' => $responseReview
            ]);
        }

        $response = [
            'status' => 200,
            'data' => $responseData,
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
            'message' => "Save favorite book successfully!",
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
