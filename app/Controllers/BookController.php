<?php

namespace App\Controllers;

use App\Models\BookModel;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class BookController extends Controller
{
    use ResponseTrait;

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
        return view('BookView');
    }

    /**
     * Tampilkan daftar index.
     *
     * @param \CodeIgniter\HTTP\RequestInterface
     *
     * @return \CodeIgniter\Http\Response
     */
    public function show()
    {
    }

    /**
     * Simpan resource ke database.
     *
     * @param \CodeIgniter\HTTP\RequestInterface
     *
     * @return \CodeIgniter\Http\Response
     */
    public function create()
    {
        if ($this->model->insert($this->request->getPost())) {
            return $this->respondCreated();
        }

        return $this->fail($this->model->errors());
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
        if ($found = $this->model->find($id)) {
            return $this->respond(['data' => $found]);
        }

        return $this->fail('Failed');
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
        if ($this->model->update($id, $this->request->getRawInput())) {
            return $this->respondCreated();
        }

        return $this->fail($this->model->errors());
    }

    /**
     * Hapus resource spesifik ke database.
     *
     * @param int $id
     *
     * @return CodeIgniter\Http\Response
     */
    public function delete($id)
    {
        if ($found = $this->model->delete($id)) {
            return $this->respondDeleted($found);
        }

        return $this->fail('Fail deleted');
    }

    public function datatable()
    {
        if ($this->request->isAJAX()) {
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
                    $draw = $this->request->getPost('draw');
                    $books = $this->model->listAll($order, $dir, $limit, $start);
                } else {
                    $draw = $this->request->getPost('draw');
                    $books = $this->model->listSearchBook($order, $dir, $limit, $start, $search);
                    $filtered = $this->model->countSearchBook($search);
                    $totalFiltered = $filtered;
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
        }
    }
}
