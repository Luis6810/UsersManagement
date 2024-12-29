<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeleteUserTest extends TestCase
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

    public function test_delete_user_success(): void
    {
        $users = User::factory()->count(3)->create();

        $user_id = (int) $users->first()->id;


        // $user_id = User::find(1);
        $response = $this->delete('/api/user/' . $user_id, ["Authorization" => $this->token]);

        $response->assertStatus(204);
    }

    public function test_delete_user_not_found():void
    {
        //Act
        $response = $this->delete('/api/user/' . 1,["Authorization" => $this->token]);
        //Assert
        $response->assertStatus(404);

    }
}
