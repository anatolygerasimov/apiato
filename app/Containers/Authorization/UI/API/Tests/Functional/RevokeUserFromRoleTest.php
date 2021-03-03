<?php

declare(strict_types=1);

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\Tests\ApiTestCase;
use App\Containers\User\Models\User;

/**
 * Class RevokeUserFromRoleTest.
 *
 * @group authorization
 * @group api
 */
class RevokeUserFromRoleTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'post@v1/roles/revoke';

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
    public function testRevokeUserFromRole(): void
    {
        $roleA = factory(Role::class)->create();

        $randomUser = factory(User::class)->create();
        $randomUser->assignRole($roleA);

        $data = [
            'roles_ids' => [$roleA->getHashedKey()],
            'user_id'   => $randomUser->getHashedKey(),
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($data['user_id'], $responseContent->data->id);

        $this->assertDatabaseMissing('model_has_roles', [
            'model_id' => $randomUser->id,
            'role_id'  => $roleA->id,
        ]);
    }

    /**
     * @test
     */
    public function testRevokeUserFromRoleWithRealId(): void
    {
        $roleA = factory(Role::class)->create();

        $randomUser = factory(User::class)->create();
        $randomUser->assignRole($roleA);

        $data = [
            'roles_ids' => [$roleA->id],
            'user_id'   => $randomUser->id,
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
    public function testRevokeUserFromManyRoles(): void
    {
        $roleA = factory(Role::class)->create();
        $roleB = factory(Role::class)->create();

        $randomUser = factory(User::class)->create();
        $randomUser->assignRole($roleA);
        $randomUser->assignRole($roleB);

        $data = [
            'roles_ids' => [$roleA->getHashedKey(), $roleB->getHashedKey()],
            'user_id'   => $randomUser->getHashedKey(),
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertDatabaseMissing('model_has_roles', [
            'model_id' => $randomUser->id,
            'role_id'  => $roleA->id,
        ]);

        $this->assertDatabaseMissing('model_has_roles', [
            'model_id' => $randomUser->id,
            'role_id'  => $roleB->id,
        ]);
    }
}
