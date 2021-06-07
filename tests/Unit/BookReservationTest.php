<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_cheked_out()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $book->checkout($user);

        self::assertCount(1, Reservation::all());
        self::assertEquals($user->id, Reservation::first()->user_id);
        self::assertEquals($book->id, Reservation::first()->book_id);
        self::assertEquals(now(), Reservation::first()->checked_out_at);
    }


    public function test_a_book_can_be_return()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $book->checkout($user);

        $book->checkin($user);

        self::assertCount(1, Reservation::all());
        self::assertEquals($user->id, Reservation::first()->user_id);
        self::assertEquals($book->id, Reservation::first()->book_id);
        self::assertNotNull(Reservation::first()->checked_in_at);
        self::assertEquals(now(), Reservation::first()->checked_in_at);
    }


    public function test_a_user_can_checkout_a_book_twice()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $book->checkout($user);
        $book->checkin($user);

        $book->checkout($user);

        self::assertCount(2, Reservation::all());
        self::assertEquals($user->id, Reservation::find(2)->user_id);
        self::assertEquals($book->id, Reservation::find(2)->book_id);
        self::assertNull(Reservation::find(2)->checked_in_at);
        self::assertEquals(now(), Reservation::find(2)->checked_out_at);

        $book->checkin($user);

        self::assertCount(2, Reservation::all());
        self::assertEquals($user->id, Reservation::find(2)->user_id);
        self::assertEquals($book->id, Reservation::find(2)->book_id);
        self::assertNotNull(Reservation::find(2)->checked_out_at);
        self::assertEquals(now(), Reservation::find(2)->checked_in_at);
    }


    public function test_if_not_checked_out_exception_is_thrown()
    {
        $this->expectException(\Exception::class);

        $user = User::factory()->create();
        $book = Book::factory()->create();

        $book->checkin($user);

    }
}
