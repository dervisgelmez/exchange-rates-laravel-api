<?php

namespace Tests\Unit;

use App\Models\UserRequestLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Checks if a request log is created when an authenticated user makes a request.
     * @return void
     */
    public function test_user_request_log(): void
    {
        $requestLogCount = UserRequestLog::count();
        $this->assertEquals(0, $requestLogCount);

        $this
            ->makeResponseWithAuthenticatedUser()
            ->get('api/auth/me');

        $requestLogCount = UserRequestLog
            ::query()
            ->where('user_id', '=', 1)
            ->count();

        $this->assertEquals(1, $requestLogCount);
    }

    /**
     * Checks if an unauthorized request returns the expected JSON response.
     * @return void
     */
    public function test_unauthorized()
    {
        $response = $this
            ->makeResponseWithAuthenticatedUser()
            ->get('api/admin/users');

        $response->assertJson([
            'success' => false,
            'message' => 'UNAUTHORIZED_ACTION',
            'data' => null
        ]);
    }

    /**
     * Checks if an authorized request to the admin endpoint returns the expected JSON structure.
     * @return void
     */
    public function test_authorized()
    {
        $response = $this
            ->makeResponseWithAuthenticatedAdmin()
            ->get('api/admin/users');

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    '*' => [
                        'user_id',
                        'username',
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]
        ]);
    }
}
