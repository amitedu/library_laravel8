<?php

namespace App\Http\Controllers;

use App\Models\Book;

class CheckoutController extends Controller
{
    public function store(Book $book)
    {
        $book->checkout(auth()->user());
    }
}
