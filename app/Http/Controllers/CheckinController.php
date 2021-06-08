<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CheckinController extends Controller
{

    public function store(Book $book)
    {
        try {
            $book->checkin(auth()->user());
        } catch (\Exception $e) {
            return response([], 404);
        }
    }
}
