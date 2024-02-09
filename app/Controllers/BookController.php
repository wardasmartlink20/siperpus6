<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;

class BookController extends BaseController
{
    use ResponseTrait;

    protected $bookModel, $categoryModel, $books;
    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->categoryModel = new CategoryModel();
        $this->books = $this->bookModel
            ->join('categories', 'categories.category_id = books.category_id')
            ->findAll();
    }

    public function booksView()
    {
        $categories = $this->categoryModel->findAll();
        $data = [
            "data" => $this->books,
            "categories" => $categories,
        ];
        return view('pages/books/index', $data);
    }

    public function listBooksApi()
    {
        $response = [
            "data" => $this->books,
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
