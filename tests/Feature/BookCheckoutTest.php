<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_checked_out_by_a_signed_in_user(): void
    {
        $this->withoutExceptionHandling();

        $book = Book::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/checkout/' . $book->id);

        self::assertCount(1, Reservation::all());
        self::assertEquals($user->id, Reservation::first()->user_id);
        self::assertEquals($book->id, Reservation::first()->book_id);
        self::assertEquals(now(), Reservation::first()->checked_out_at);
    }


    public function test_only_signed_in_users_can_checkout_a_book(): void
    {
        $book = Book::factory()->create();

        $this->post('/checkout/' . $book->id)->assertRedirect('/login');

        self::assertCount(0, Reservation::all());
    }


    public function test_only_a_real_book_can_be_checked_out(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/checkout/123')
            ->assertStatus(404);

        self::assertCount(0, Reservation::all());
    }


    public function test_a_book_can_be_checked_in_by_a_signed_in_user()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $book = Book::factory()->create();
        $this->actingAs($user)
            ->post('/checkout/' . $book->id);

        $this->actingAs($user)
            ->post('/checkin/' . $book->id);

        self::assertCount(1, Reservation::all());
        self::assertEquals($user->id, Reservation::first()->user_id);
        self::assertEquals($book->id, Reservation::first()->book_id);
        self::assertEquals(now(), Reservation::first()->checked_out_at);
        self::assertEquals(now(), Reservation::first()->checked_in_at);
    }


    public function test_only_signed_in_users_can_checkin_a_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $this->actingAs($user)
            ->post('/checkout/' . $book->id);

        Auth::logout();

        $this->post('/checkin/' . $book->id)->assertRedirect('/login');

        self::assertNull(Reservation::first()->checked_in_at);
    }


    public function test_a_404_is_thrown_if_a_book_is_not_checked_out_first()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $this->actingAs($user)
            ->post('/checkin/' . $book->id)
            ->assertStatus(404);

        self::assertCount(0, Reservation::all());
    }
}
