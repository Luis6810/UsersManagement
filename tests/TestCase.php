<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    //

    protected $token;
    protected $user;

    public function loginUser(): void {
        $users = User::factory()->count(3)->create();
        // $this->user = User::factory()->create();
        $this->user = $users->first();
        $credentials = [
            "email" => $this->user->email,
            // $user->only('email'),
            "password" => "password"
        ];
        // $credentials->

        $this->token = Auth::attempt($credentials);
    }
}
