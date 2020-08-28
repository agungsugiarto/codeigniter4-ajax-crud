<?php

namespace App\Controllers;

use App\Models\Book;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    //--------------------------------------------------------------------

    public function eloquent()
    {
        service('eloquent');

        return $this->response->setJSON(Book::paginate());
    }
}
