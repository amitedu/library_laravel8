<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_author_can_be_created(): void
    {
        $this->post('/author', [
            'name' => 'amit',
            'dob' => '05/06/2021',
        ]);

        $authors = Author::all();

        self::assertCount(1, $authors);
        self::assertInstanceOf(Carbon::class, $authors->first()->dob);
        self::assertEquals('05/06/2021', $authors->first()->dob->format('m/d/Y'));
    }
}
