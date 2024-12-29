<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use SebastianBergmann\Type\VoidType;

class GetUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loginUser();
    }

    public function test_get_user_success(): void
    {
        $users = User::factory()->count(3)->create();

        $user_id = (int) $users->first()->id;

        // $user_id = User::find(1);
        $response = $this->get('/api/user/' . $user_id, ["Authorization" => $this->token]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ]);
    }

    public function test_get_user_not_found(): void
    {
        $response = $this->get('/api/user/' . 1, ["Authorization" => $this->token]);
        $response->assertStatus(404);

    }


}
