<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JWTAuthRegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_register_success(): void
    {
        $data = [
            'email' => 'test@example.com',
            'name' => 'Alejandro',
            'password' => 'password',
        ];
        $response = $this->post('/api/register',$data);

        // Assert token is returned
        $response->assertStatus(200)
        ->assertJsonStructure([
            'authorization' => ['token','type']
        ]);

       $token = $response->json('authorization')['token'];;
       $this->assertNotEmpty($token);
    }

    public function test_register_validation_error():void
    {
                //Arrange

        //Act
        $response = $this->postJson('/api/register', [
            'email' => 'vfd',
            'password' => 'pass',
        ]);
        //Assert
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["email","password"]);
    }

}
