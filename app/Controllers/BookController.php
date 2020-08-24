<?php

namespace App\Controllers;

use App\Models\BookModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

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
     * @return \CodeIgniter\Http\Response
     */
    public function index()
    {
        return view('BookView');
    }

    /**
     * Tampilkan daftar index.
     *
     * @return \CodeIgniter\Http\Response
     */
    public function show()
    {
    }

    /**
     * Simpan resource ke database.
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

    /**
     * Function datatable.
     *
     * @return CodeIgniter\Http\Response
     */
    public function datatable()
    {
        if ($this->request->isAJAX()) {
            $start = $this->request->getPost('start');
            $length = $this->request->getPost('length');
            $search = $this->request->getPost('search[value]');
            $order = BookModel::ORDERABLE[$this->request->getPost('order[0][column]')];
            $dir = $this->request->getPost('order[0][dir]');

            return $this->respond([
                'draw'            => $this->request->getPost('draw'),
                'recordsTotal'    => $this->model->getResource()->countAllResults(),
                'recordsFiltered' => $this->model->getResource($search)->countAllResults(),
                'data'            => $this->model->getResource($search)->orderBy($order, $dir)->limit($length, $start)->get()->getResultObject(),
            ]);
        }

        return $this->respondNoContent();
    }
}
