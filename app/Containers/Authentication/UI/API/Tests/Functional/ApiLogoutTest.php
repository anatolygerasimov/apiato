<?php

declare(strict_types=1);

namespace App\Containers\Authentication\UI\API\Tests\Functional;

use App\Containers\Authentication\Tests\ApiTestCase;
use Laravel\Passport\Passport;

/**
 * Class ApiLogoutTest.
 *
 * @group authorization
 * @group api
 */
class ApiLogoutTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'delete@v1/logout';

    /**
     * @var array
     */
    protected $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * @test
     */
    public function testLogout(): void
    {
        $user = $this->getTestingUser();
        Passport::actingAs($user);

        $response = $this->makeCall();

        $response->assertStatus(202);

        $this->assertResponseContainKeyValue([
            'message' => 'Token revoked successfully.',
        ]);
    }
}
