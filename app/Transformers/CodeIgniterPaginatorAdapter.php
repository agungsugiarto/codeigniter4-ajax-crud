<?php

namespace App\Transformers;

use CodeIgniter\Pager\Pager;
use League\Fractal\Pagination\PaginatorInterface;

class CodeIgniterPaginatorAdapter implements PaginatorInterface
{
    /**
     * The pagiantor.
     *
     * @var \CodeIgniter\Pager\Pager
     */
    protected $paginator;

    /**
     * Create a new illuminate pagination adapter.
     *
     * @param \CodeIgniter\Pager\Pager $paginator
     *
     * @return void
     */
    public function __construct(Pager $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentPage()
    {
        return $this->paginator->getCurrentPage();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastPage()
    {
        return $this->paginator->getLastPage();
    }

    /**
     * {@inheritdoc}
     */
    public function getTotal()
    {
        // TODO: Change to getTotal() on new release version.
        return $this->paginator->getDetails()['total'];
    }

    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        return $this->paginator->getPageCount();
    }

    /**
     * {@inheritdoc}
     */
    public function getPerPage()
    {
        return $this->paginator->getPerPage();
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($page)
    {
        return $this->paginator->getPageURI($page);
    }

    /**
     * Get the paginator instance.
     *
     * @return \CodeIgniter\Pager\Pager
     */
    public function getPaginator()
    {
        return $this->paginator;
    }
}
