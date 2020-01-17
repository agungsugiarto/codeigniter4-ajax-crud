<?php

namespace App\Controllers;

use App\Models\BookModel;
use CodeIgniter\Controller;

class BookController extends Controller
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct()
    {
        $this->model = new BookModel();
    }

    /**
     * Tampilkan daftar index.
     *
     * @param \CodeIgniter\HTTP\RequestInterface
     *
     * @return \CodeIgniter\Http\Response
     */
    public function index()
    {
        $model = new BookModel();

        if ($this->request->isAJAX()) {
            $columns = [
                0 => 'id',
                1 => 'title',
                2 => 'author',
                3 => 'description',
                4 => 'status',
            ];

            $totalData = $this->model->countAllResults();
            $totalFiltered = $totalData;
            $limit = $this->request->getPost('length');
            $start = $this->request->getPost('start');
            $order = $columns[$this->request->getPost('order[0][column]')];
            $dir = $this->request->getPost('order[0][dir]');
            $search = $this->request->getPost('search[value]');

            if (empty($search)) {
                $books = $model->orderBy($order, $dir)
                               ->findAll($limit, $start);

                $draw = $this->request->getPost('draw');
            } else {
                $draw = $this->request->getPost('draw');

                $books = $model->orderBy($order, $dir)
                               ->like('title', $search)
                               ->orLike('author', $search)
                               ->orLike('description', $search)
                               ->orLike('status', $search)
                               ->findAll($limit, $start);

                $Filtered = $model->like('title', $search)
                                  ->orLike('author', $search)
                                  ->orLike('description', $search)
                                  ->orLike('status', $search)
                                  ->countAllResults();

                $totalFiltered = $Filtered;
            }

            if (!empty($books)) {
                foreach ($books as $book) {
                    $nested['id'] = $book['id'];
                    $nested['title'] = $book['title'];
                    $nested['author'] = $book['author'];
                    $nested['description'] = $book['description'];
                    $nested['status'] = $book['status'];
                    $nested['action'] = "<button type='button' class='btn btn-warning btn-xs btn-edit' data-id='{$book['id']}'>Edit</button> <button type='button' class='btn btn-danger btn-xs btn-delete' data-id='{$book['id']}'>Delete</button>";
                    $data[] = $nested;
                }
            } else {
                $data = [];
                $totalData = 0;
                $draw = 0;
            }

            return $this->response->setJSON([
                'draw'            => $draw,
                'recordsTotal'    => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data'            => $data,
            ]);
        }

        return view('BookView');
    }

    /**
     * Simpan resource ke database.
     *
     * @param \CodeIgniter\HTTP\RequestInterface
     *
     * @return \CodeIgniter\Http\Response
     */
    public function store()
    {
        $data = $this->request->getRawInput();

        if (!$this->model->save($data)) {
            return $this->response->setJSON(['errors' => $this->model->errors()]);
        }

        return $this->response->setJSON(['messages' => 'Success insert book']);
    }

    /**
     * Tampilkan form untuk mengedit yang ditentukan.
     *
     * @param int $id
     *
     * @return CodeIgniter\Http\Response
     */
    public function edit($id)
    {
        return $this->response->setJSON(['data' => $this->model->find($id)]);
    }

    /**
     * Update resource spesifik ke database.
     *
     * @param int $id
     *
     * @return CodeIgniter\Http\Response
     */
    public function update($id)
    {
        $data = $this->request->getRawInput();

        if (!$this->model->update($id, $data)) {
            return $this->response->setJSON(['errors' => $this->model->errors()]);
        }

        return $this->response->setJSON(['messages' => 'Success update book']);
    }

    /**
     * Hapus resource spesifik ke database.
     *
     * @param int $id
     *
     * @return CodeIgniter\Http\Response
     */
    public function destroy($id)
    {
        return $this->model->delete($id);
    }
}
