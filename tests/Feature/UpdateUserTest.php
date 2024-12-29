<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;

class UpdateUserTest extends TestCase
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
    public function test_update_user(): void
    {
        //Arrange
        // $users = User::factory()->count(3)->create();


        // $token = $user->getJWTIdentifier();
        $user_id = $this->user->id;

        $data = [
            'name' => 'Romeo Santos',
            'email' => 'romeoa@gmail.com',
            'password' => 'cvavadfd',
        ];
        //Act
        $response = $this->put('/api/user/'. $user_id ,$data,["Authorization" => $this->token]);

        //Assert
        $response->assertStatus(200);

        $this->assertDatabaseHas('users',
            [
                'name' => $data['name'],
                'email' =>  $data['email'],
            ]
        );
    }

    public function test_update_user_not_found(): void
    {
        //Arrange

        $data = [
            'name' => 'Romeo Santos',
            'email' => 'romeo@gmail.com',
            'password' => 'cvavadfd',
        ];
        //Act
        $response = $this->put('/api/user/'. 100 ,$data,["Authorization" => $this->token]);
        //Assert
        $response->assertStatus(404);

    }

    public function test_update_user_validation_error(): void
    {
        //Arrange

        $user_id = $this->user->id;

        $data = [
            'name' => 'l',
            'email' => 'romeogmail.com',
            'password' => 'cd',
        ];
        //Act
        $response = $this->put('/api/user/'. $user_id ,$data,["Authorization" => $this->token]);

        //Assert
        $response->assertStatus(422);

        $response->assertJsonValidationErrors(["email","name","password"]);

    }
}
