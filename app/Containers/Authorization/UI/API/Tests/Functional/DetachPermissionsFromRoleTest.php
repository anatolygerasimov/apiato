<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\Tests\ApiTestCase;

/**
 * Class DetachPermissionsFromRoleTest.
 *
 * @group authorization
 * @group api
 */
class DetachPermissionsFromRoleTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'post@v1/permissions/detach';

    /**
     * @var array
     */
    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-roles',
    ];

    /**
     * @test
     */
    public function testDetachSinglePermissionFromRole(): void
    {
        $permissionA = factory(Permission::class)->create();

        $roleA = factory(Role::class)->create();
        $roleA->givePermissionTo($permissionA);

        $data = [
            'role_id'         => $roleA->getHashedKey(),
            'permissions_ids' => [$permissionA->getHashedKey()],
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($roleA->name, $responseContent->data->name);

        $this->assertDatabaseMissing('role_has_permissions', [
            'permission_id' => $permissionA->id,
            'role_id'       => $roleA->id,
        ]);
    }

    /**
     * @test
     */
    public function testDetachMultiplePermissionFromRole(): void
    {
        $permissionA = factory(Permission::class)->create();
        $permissionB = factory(Permission::class)->create();

        $roleA = factory(Role::class)->create();
        $roleA->givePermissionTo($permissionA);
        $roleA->givePermissionTo($permissionB);

        $data = [
            'role_id'         => $roleA->getHashedKey(),
            'permissions_ids' => [$permissionA->getHashedKey(), $permissionB->getHashedKey()],
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($roleA->name, $responseContent->data->name);

        $this->assertDatabaseMissing('role_has_permissions', [
            'permission_id' => $permissionA->id,
            'role_id'       => $roleA->id,
        ]);

        $this->assertDatabaseMissing('role_has_permissions', [
            'permission_id' => $permissionB->id,
            'role_id'       => $roleA->id,
        ]);
    }
}
