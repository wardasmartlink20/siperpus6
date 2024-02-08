<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookModel;

class BookController extends BaseController
{
    protected $bookModel;
    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function booksView()
    {
        $books = $this->bookModel->findAll();
        $data = [
            "data" => $books,
        ];
        return view('pages/books/index', $data);
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
