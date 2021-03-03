<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\Tests\ApiTestCase;
use App\Containers\User\Models\User;
use Illuminate\Support\Arr;

/**
 * Class AssignUserToRoleTest.
 *
 * @group authorization
 * @group api
 */
class AssignUserToRoleTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'post@v1/roles/assign?include=roles';

    /**
     * @var array
     */
    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-admins-access',
    ];

    /**
     * @test
     */
    public function testAssignUserToRole(): void
    {
        $randomUser = factory(User::class)->create();

        $role = factory(Role::class)->create();

        $data = [
            'roles_ids' => [$role->getHashedKey()],
            'user_id'   => $randomUser->getHashedKey(),
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($data['user_id'], $responseContent->data->id);

        $this->assertEquals($data['roles_ids'][0], $responseContent->data->roles->data[0]->id);
    }

    /**
     * @test
     */
    public function testAssignUserToRoleWithRealId(): void
    {
        $randomUser = factory(User::class)->create();

        $role = factory(Role::class)->create();

        $data = [
            'roles_ids' => [$role->id], // testing against real ID's
            'user_id'   => $randomUser->id, // testing against real ID's
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct. Note: this will return 200 if `HASH_ID=false` in the .env
        if (config('apiato.hash-id')) {
            $response->assertStatus(400);

            $this->assertResponseContainKeyValue([
                'message' => 'Only Hashed ID\'s allowed.',
            ]);
        } else {
            $response->assertStatus(200);
        }
    }

    /**
     * @test
     */
    public function testAssignUserToManyRoles(): void
    {
        $randomUser = factory(User::class)->create();

        $role1 = factory(Role::class)->create();
        $role2 = factory(Role::class)->create();

        $data = [
            'roles_ids' => [
                $role1->getHashedKey(),
                $role2->getHashedKey(),
            ],
            'user_id'   => $randomUser->getHashedKey(),
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertTrue(count($responseContent->data->roles->data) > 1);

        $roleIds = Arr::pluck($responseContent->data->roles->data, 'id');
        $this->assertContains($data['roles_ids'][0], $roleIds);

        $this->assertContains($data['roles_ids'][1], $roleIds);
    }
}
