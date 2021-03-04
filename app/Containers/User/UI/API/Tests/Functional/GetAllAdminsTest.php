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
class GetAllAdminsTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'get@v1/admins';

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
    public function testGetAllAdmins(): void
    {
        // create some non-admin users
        factory(User::class, 2)->create();

        // should not be returned
        $user = factory(User::class)->states('client')->create();

        Apiato::call('Authorization@AssignUserToRoleTask', [$user, ['admin']]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        // assert the returned data size is correct
        // 1 (fake in this test) + 1 (seeded super user/admin)
        $this->assertCount(2, $responseContent->data);
    }

    /**
     * @test
     */
    public function testGetAllAdminsByNonAdmin(): void
    {
        $this->getTestingUserWithoutAccess();

        // create some fake users
        factory(User::class, 2)->create();

        // send the HTTP request
        $response = $this->makeCall();
        // assert response status is correct
        $response->assertStatus(403);

        $this->assertResponseContainKeyValue([
            'message' => 'This action is unauthorized.',
        ]);
    }
}
