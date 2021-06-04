<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function store(): void
    {
        Book::create($this->getValidate());
    }


    public function update(Book $book): void
    {
        $book->update($this->getValidate());
    }


    /**
     * @return array
     */
    protected function getValidate(): array
    {
        return \request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }

}
