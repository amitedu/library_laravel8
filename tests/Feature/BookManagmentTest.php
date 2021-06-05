<?php

namespace Tests\Feature;

use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_added_to_the_library(): void
    {
        $response = $this->post('/books', [
            'title' => 'a cool book',
            'author' => 'amit'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());
    }


    public function test_a_title_is_required(): void
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'amit'
        ]);

        $response->assertSessionHasErrors('title');
    }


    public function test_a_author_is_required(): void
    {
        $response = $this->post('/books', [
            'title' => 'cool book',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }


    public function test_a_book_can_be_updated(): void
    {
        $this->post('/books', [
            'title' => 'Cool Book',
            'author' => 'amit'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        self::assertEquals('New Title', Book::first()->title);
        self::assertEquals('New Author', Book::first()->author);

        $response->assertRedirect($book->fresh()->path());
    }


    public function test_a_book_can_be_deleted(): void
    {
        $this->post('/books', [
            'title' => 'cool book title',
            'author' => 'amit'
        ]);

        $book = Book::first();

        self::assertCount(1, Book::all());

        $response = $this->delete('/books/' . $book->id);

        self::assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
