<?php

namespace Tests\Feature;

use App\Http\Controllers\BookController;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_added_to_the_library(): void
    {
        $response = $this->post('/books', $this->data());

        $book = Book::first();

        self::assertCount(1, Book::all());

        $response->assertRedirect($book->path());
    }


    public function test_a_title_is_required(): void
    {
        $response = $this->post('/books',
            array_merge($this->data(), ['title' => ''])
        );

        $response->assertSessionHasErrors('title');
    }


    public function test_a_author_is_required(): void
    {
        $response = $this->post('/books',
            array_merge($this->data(), ['author_id' => ''])
        );

        $response->assertSessionHasErrors('author_id');
    }


    public function test_a_book_can_be_updated(): void
    {
        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        self::assertEquals('New Title', Book::first()->title);
        self::assertEquals(2, Book::first()->author_id);

        $response->assertRedirect($book->fresh()->path());
    }


    public function test_a_book_can_be_deleted(): void
    {
        $this->post('/books', $this->data());

        $book = Book::first();

        self::assertCount(1, Book::all());

        $response = $this->delete('/books/' . $book->id);

        self::assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }


    public function test_author_can_be_added_automatically(): void
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();
        $author = Author::first();

        self::assertEquals($author->id, $book->author_id);
        self::assertCount(1, Author::all());
    }


    /**
     * @return string[]
     */
    private function data(): array
    {
        return [
            'title' => 'a cool book',
            'author_id' => 'amit'
        ];
    }

}
