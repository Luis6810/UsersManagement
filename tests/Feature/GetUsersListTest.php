<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class GetUsersListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    public function test_get_users_sucess(): void
    {
        //Arrange
        $posts = User::factory()->count(3)->create();

        $response = $this->get('/api/users');
        // $response->assertExactJson();
        // print(type($response));
        $response->assertStatus(200)->assertJsonCount(3)->assertJsonStructure([
            '*' => [
                'id',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
