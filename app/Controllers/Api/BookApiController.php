<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Criteria\BookCriteria;
use App\Models\BookModel;
use App\Repository\BookRepository;
use App\Transformers\Book\BookTransformer;
use CodeIgniter\Config\Config;

class BookApiController extends BaseController
{
    protected $book;
    protected $pager;

    public function __construct()
    {
        $this->book = new BookRepository();
        $this->pager = Config::get('Pager')->perPage;
    }

    /**
     * index.
     *
     * @return \CodeIgniter\Http\Response
     */
    public function index()
    {
        $resource = $this->book->scope($this->request)
            ->withCriteria([new BookCriteria()])
            ->paginate(null, static::withSelect());

        return $this->fractalCollection($resource, new BookTransformer());
    }

    /**
     * show.
     *
     * @return \CodeIgniter\Http\Response
     */
    public function show($id = null)
    {
        $resource = $this->book->withCriteria([new BookCriteria()])->find($id, static::withSelect());

        if (is_null($resource)) {
            return $this->failNotFound(sprintf('book with id %d not found', $id));
        }

        return $this->fractalItem($resource, new BookTransformer());
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
            $resource = $this->book->create($request);
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
            $this->book->update($request, $id);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }

        return $this->respondUpdated(['id' => $id], "book id {$id} updated");
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
        $this->book->destroy($id);

        if ((new BookModel())->db->affectedRows() === 0) {
            return $this->failNotFound(sprintf('book with id %d not found or already deleted', $id));
        }

        return $this->respondDeleted(['id' => $id], "book id {$id} deleted");
    }

    /**
     * With select.
     *
     * @return array
     */
    protected static function withSelect()
    {
        return [
            'books.id', 'books.status_id', 'books.title', 'books.author', 'status.status', 'books.description', 'books.created_at', 'books.updated_at',
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
            'status_id'   => 'required|numeric',
            'title'       => 'required|min_length[10]|max_length[60]',
            'author'      => 'required|min_length[10]|max_length[200]',
            'description' => 'required|min_length[10]|max_length[200]',
        ];
    }
}
