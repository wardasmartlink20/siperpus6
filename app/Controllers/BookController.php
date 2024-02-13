<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\BorrowModel;
use App\Models\CategoryModel;
use App\Models\ReviewModel;
use CodeIgniter\API\ResponseTrait;

class BookController extends BaseController
{
    use ResponseTrait;

    protected $bookModel, $categoryModel, $reviewModel, $borrowModel, $books;
    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->categoryModel = new CategoryModel();
        $this->reviewModel = new ReviewModel();
        $this->borrowModel = new BorrowModel();
        $this->books = $this->bookModel
            ->join('categories', 'categories.category_id = books.category_id')
            ->findAll();
    }

    public function booksView()
    {
        $currentPage = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $categories = $this->categoryModel->findAll();
        $totalLimit = 10;
        $offset = ($currentPage - 1) * $totalLimit;
        $books = $this->bookModel
            ->join('categories', 'categories.category_id = books.category_id')
            ->findAll($totalLimit, $offset);

        $totalRows = $this->bookModel
            ->join('categories', 'categories.category_id = books.category_id')
            ->countAllResults();

        $totalPages = ceil($totalRows / $totalLimit);
        $data = [
            "data" => $books,
            "categories" => $categories,
            "pager" => [
                "totalPages" => $totalPages,
                "currentPage" => $currentPage,
                "limit" => $totalLimit,
            ],
        ];
        return view('pages/books/index', $data);
    }

    public function listBooksApi()
    {
        // Get the category ID from the request
        $categoryId = $this->request->getVar('category');

        // Initialize an empty array for books
        $books = [];

        // Check if a category ID is provided
        if ($categoryId) {
            // If a category ID is provided, fetch books with a matching category
            $books = $this->bookModel
                ->join('categories', 'categories.category_id = books.category_id')
                ->where(['books.category_id' => $categoryId])
                ->findAll();
        } else {
            // If no category ID is provided, fetch all books
            $books = $this->bookModel->findAll();
        }

        // Initialize an empty array for the final response
        $responseData = [];

        // Loop through each book
        foreach ($books as $book) {
            // Fetch reviews for the current book
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
                'rating' => round($averageRating, 1),
                'reviews' => $responseReview
            ]);
        }

        // Prepare the final response
        $response = [
            "status" => 200,
            "data" => $responseData,
        ];

        // Return the response
        return $this->respond($response, 200);
    }

    public function detailBookApi($id)
    {
        $book = $this->bookModel
            ->join('categories', 'categories.category_id = books.category_id')
            ->where(['books.book_id' => $id])
            ->first();

        // Initialize an empty array for the final response
        $responseData = [];

        $reviews = $this->reviewModel
            ->join('users', 'users.user_id = reviews.user_id')
            ->where(['book_id' => $id])
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
        // Append book information and cleaned reviews directly to the response array
        $averageRating = count($reviews) > 0 ? $totalRating / count($reviews) : 0;

        $responseData = array_merge($book, [
            'rating' => round($averageRating, 1),
            'reviews' => $responseReview
        ]);

        // Prepare the final response
        $response = [
            "status" => 200,
            "data" => $responseData,
        ];

        // Return the response
        return $this->respond($response, 200);
    }

    public function getPopularBooks()
    {
        $builder = $this->borrowModel;
        $builder->select('books.*, COUNT(borrows.book_id) as borrow_count');
        $builder->join('books', 'books.book_id = borrows.book_id');
        $builder->groupBy('borrows.book_id');
        $builder->orderBy('borrow_count', 'DESC');

        $response = [
            "status" => 200,
            "data" => $builder->get()->getResult(),
        ];

        return $this->respond($response, 200);
    }

    public function create()
    {
        helper(['form']);

        $thumbnail = $this->request->getFile('thumbnail');
        $fileName = $thumbnail->getRandomName();
        $thumbnail->move('assets/books', $fileName);

        $data = [
            'title' => $this->request->getVar('title'),
            'writer' => $this->request->getVar('writer'),
            'publisher' => $this->request->getVar('publisher'),
            'year_publication' => $this->request->getVar('year_publication'),
            'synopsis' => $this->request->getVar('synopsis'),
            'thumbnail' => '/assets/books/' . $fileName,
            'category_id' => $this->request->getVar('category_id'),
        ];

        $this->bookModel->save($data);
        session()->setFlashdata('success', 'Create Book Successfully.');
        return redirect()->to(base_url("/books"));
    }

    public function update($id)
    {
        helper(['form']);
        $thumbnail = $this->request->getFile('thumbnail');
        $fileName = $thumbnail->getRandomName();
        $thumbnail->move('assets/books', $fileName);

        $data = [
            'book_id' => $id,
            'title' => $this->request->getVar('title'),
            'writer' => $this->request->getVar('writer'),
            'publisher' => $this->request->getVar('publisher'),
            'year_publication' => $this->request->getVar('year_publication'),
            'synopsis' => $this->request->getVar('synopsis'),
            'thumbnail' => '/assets/books/' . $fileName,
        ];

        $this->bookModel->replace($data);
        session()->setFlashdata('success', 'Update Book Successfully.');
        return redirect()->to(base_url("/books"));
    }

    public function delete($id)
    {
        $this->bookModel->where(['book_id' => $id])->delete();
        session()->setFlashdata('success', 'Delete Book successfully.');
        return redirect()->to(base_url('/books'));
    }
}
