<?php

namespace Tests\Feature;

use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'a cool book',
            'author' => 'amit'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }


    public function test_a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'amit'
        ]);

        $response->assertSessionHasErrors('title');
    }


    public function test_a_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'cool book',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }


    public function test_a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool Book',
            'author' => 'amit'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        self::assertEquals('New Title', Book::first()->title);
        self::assertEquals('New Author', Book::first()->author);
    }
}
