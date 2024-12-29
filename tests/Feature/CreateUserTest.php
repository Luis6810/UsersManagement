<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTest extends TestCase
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
    public function test_create_user_success(): void
    {
        //Arrange
        $data = [
            'name' => 'Romeo Santos',
            'email' => 'romeo@gmail.com',
            'password' => 'cvavadfd',
        ];

        $response = $this->post('/api/user',$data,["Authorization" => $this->token]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users',
            [
                'name' => $data['name'],
                'email' =>  $data['email'],
            ]
        );
    }

    public function test_create_user_fail(): void
    {
        //Arrange
        $data = [
            'name' => 'not',
            'email' => 'invalid',
            'password' => 'invalid',

        ];

        $response = $this->post('/api/user',$data,["Authorization" => $this->token]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(["email","name","password"]);
    }
}
