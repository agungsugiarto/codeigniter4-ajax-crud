<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\StatusModel;
use App\Repository\StatusRepository;
use App\Transformers\Status\StatusTransformer;
use CodeIgniter\Config\Config;

class StatusApiController extends BaseController
{
    protected $status;
    protected $pager;

    public function __construct()
    {
        $this->status = new StatusRepository();
        $this->pager = Config::get('Pager')->perPage;
    }

    /**
     * index.
     *
     * @return \CodeIgniter\Http\Response
     */
    public function index()
    {
        $resource = $this->status->scope($this->request)
            ->paginate($this->pager);

        return $this->fractalCollection($resource, new StatusTransformer());
    }

    /**
     * show.
     *
     * @return \CodeIgniter\Http\Response
     */
    public function show($id = null)
    {
        $resource = $this->status->find($id);

        if (is_null($resource)) {
            return $this->failNotFound(sprintf('status with id %d not found', $id));
        }

        return $this->fractalItem($resource, new StatusTransformer());
    }

    /**
     * create.
     *
     * @return \CodeIgniter\Http\Response
     */
    public function create()
    {
        $request = $this->request->getPost(null, FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$this->validate(static::rules())) {
            return $this->fail($this->validator->getErrors());
        }

        try {
            $resource = $this->status->create($request);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }

        return $this->respondCreated($resource);
    }

    /**
     * edit.
     *
     * @param int $id
     *
     * @return CodeIgniter\Http\Response
     */
    public function edit($id = null)
    {
        return $this->show($id);
    }

    /**
     * update.
     *
     * @param int $id
     *
     * @return CodeIgniter\Http\Response
     */
    public function update($id = null)
    {
        $request = $this->request->getRawInput();

        if (!$this->validate(static::rules())) {
            return $this->fail($this->validator->getErrors());
        }

        try {
            $this->status->update($request, $id);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }

        return $this->respondUpdated(['id' => $id], "status id {$id} updated");
    }

    /**
     * delete.
     *
     * @param int $id
     *
     * @return CodeIgniter\Http\Response
     */
    public function delete($id = null)
    {
        $this->status->destroy($id);

        if ((new StatusModel())->db->affectedRows() === 0) {
            return $this->failNotFound(sprintf('status with id %d not found or already deleted', $id));
        }

        return $this->respondDeleted(['id' => $id], "status id {$id} deleted");
    }

    /**
     * With response convert.
     *
     * @param array $resource
     *
     * @return array
     */
    protected static function withResponse(array $resource)
    {
        return [
            'data'     => $resource['data'],
            'paginate' => $resource['paginate']->getDetails(),
        ];
    }

    /**
     * Rules set.
     *
     * @return array
     */
    protected static function rules()
    {
        return [
            'status' => 'required|min_length[10]|max_length[200]',
        ];
    }
}
