<?php 

namespace App\Controllers;

use App\Models\BookModel;

class BookController extends BaseController
{
    /**
	 * @var Model
	 */
    protected $model;
    /**
	 * @var Entities
	 */
    protected $entities;

    public function __construct()
	{
        $this->model = new BookModel();
    }
    
    /**
     * Tampilkan daftar index.
     * 
     * @param \CodeIgniter\HTTP\RequestInterface
     * @return \CodeIgniter\Http\Response
     */
	public function index()
	{
        if ( $this->request->isAJAX())
        {
            $data = [
                'data' => $this->model->findALL()
            ];

            return $this->response->setJSON($data);
        }
        return view('BookView');
    }

     /**
     * Simpan resource ke database.
     * 
     * @param \CodeIgniter\HTTP\RequestInterface
     * @return \CodeIgniter\Http\Response
     */
    public function store()
    {
        $data = $this->request->getRawInput();

        if (! $this->model->save($data))
        {
            return $this->response->setJSON(['errors' => $this->model->errors()]);
        }
        return $this->response->setJSON(['messages' => 'Success insert book']);
    }
    /**
     * Tampilkan form untuk mengedit yang ditentukan.
     *
     * @param  int  $id
     * @return CodeIgniter\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'data' => $this->model->find($id)
        ];
        return $this->response->setJSON($data);
    }

    /**
     * Update resource spesifik ke database.
     *
     * @param  int  $id
     * @return CodeIgniter\Http\Response
     */
    public function update($id)
    {
        $data = $this->request->getRawInput();

        if (! $this->model->update($id, $data))
        {
            return $this->response->setJSON(['errors' => $this->model->errors()]);
        }
        return $this->response->setJSON(['messages' => 'Success update book']);
    }

    /**
     * Hapus resource spesifik ke database.
     *
     * @param  int  $id
     * @return CodeIgniter\Http\Response
     */
    public function destroy($id)
    {
        return $this->model->delete($id);
    }
}
