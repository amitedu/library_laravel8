<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{

    public function create()
    {
        return view('authors.create');
    }


    public function store(): void
    {
        Author::create($this->validateRequest());
    }


    /**
     * @return array
     */
    private function validateRequest(): array
    {
        return \request()->validate([
            'name' => 'required',
            'dob' => 'required'
        ]);
    }

}
