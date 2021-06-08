<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_author_can_be_created(): void
    {
        $this->post('/authors', $this->data());

        $authors = Author::all();

        self::assertCount(1, $authors);
        self::assertInstanceOf(Carbon::class, $authors->first()->dob);
        self::assertEquals('05/06/2021', $authors->first()->dob->format('m/d/Y'));
    }


    public function test_a_author_is_required(): void
    {
        $response = $this->post('/authors',
            array_merge($this->data(), ['name' => ''])
        );

        $response->assertSessionHasErrors('name');
    }



    public function test_a_dob_is_required(): void
    {
        $response = $this->post('/authors',
            array_merge($this->data(), ['dob' => ''])
        );

        $response->assertSessionHasErrors('dob');
    }


    /**
     * @return string[]
     */
    private function data(): array
    {
        return [
            'name' => 'amit',
            'dob' => '05/06/2021',
        ];
    }

}
