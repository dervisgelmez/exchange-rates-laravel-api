<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return TestCase
     */
    public function makeResponseWithAuthenticatedUser(): TestCase
    {
        $user = User::query()->create([
            'username' => 'test',
            'first_name' => 'test',
            'last_name' => 'test',
            'role' => User::USER_ROLE,
            'password' => 'test'
        ]);

        $token = $user->createToken('apiConnect')->plainTextToken;

        return $this
            ->actingAs($user)
            ->withHeaders([
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}"
            ]);
    }

    /**
     * @return TestCase
     */
    public function makeResponseWithAuthenticatedAdmin(): TestCase
    {
        $user = User::query()->create([
            'username' => 'test',
            'first_name' => 'test',
            'last_name' => 'test',
            'role' => User::ADMIN_ROLE,
            'password' => 'test'
        ]);

        $token = $user->createToken('apiConnect')->plainTextToken;

        return $this
            ->actingAs($user)
            ->withHeaders([
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}"
            ]);
    }
}
