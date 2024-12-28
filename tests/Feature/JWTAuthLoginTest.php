<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class JWTAuthLoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_user_login_success()
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Attempt to login
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Assert token is returned
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'authorization' => ['token','type']
                 ]);

        $token = $response->json('authorization')['token'];;
        $this->assertNotEmpty($token);
    }

    public function test_user_login_validation_error():void
    {
        //Arrange

        //Act
        $response = $this->postJson('/api/login', [
            'email' => 'vfd',
            'password' => 'pass',
        ]);
        //Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["email","password"]);

    }

    public function test_user_login_unauthorized():void
    {
        //Arrange

        //Act
        $response = $this->postJson('/api/login', [
            'email' => 'jlguerra@gmail.com',
            'password' => 'password',
        ]);
        //Assert
        $response->assertStatus(401)
                ->assertJsonStructure([
                    'status',
                    'message'
                ]);
    }

}
