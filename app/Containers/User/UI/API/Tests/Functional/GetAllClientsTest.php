<?php

declare(strict_types=1);

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Models\User;
use App\Containers\User\Tests\ApiTestCase;
use App\Ship\Core\Foundation\Facades\Apiato;

/**
 * Class GetAllUsersTest.
 *
 * @group user
 * @group api
 */
class GetAllClientsTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'get@v1/clients';

    /**
     * @var array
     */
    protected $access = [
        'roles'       => '',
        'permissions' => 'list-users',
    ];

    /**
     * @test
     */
    public function testGetAllClientsByAdmin(): void
    {
        // should be returned
        factory(User::class, 3)->states('client')->create();

        // should not be returned
        $user = factory(User::class)->create();

        Apiato::call('Authorization@AssignUserToRoleTask', [$user, ['user']]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        // assert the returned data size is correct
        // 1 (fake in this test) + 1 (seeded user)
        $this->assertCount(2, $responseContent->data);
    }

    /**
     * @test
     */
    public function testGetAllClientsByNonAdmin(): void
    {
        // prepare a user without any roles or permissions
        $this->getTestingUserWithoutAccess();

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(403);

        $this->assertResponseContainKeyValue([
            'message' => 'This action is unauthorized.',
        ]);
    }
}
