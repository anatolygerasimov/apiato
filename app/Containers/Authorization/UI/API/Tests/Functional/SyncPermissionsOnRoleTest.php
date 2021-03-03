<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\Tests\ApiTestCase;

/**
 * Class SyncPermissionsOnRoleTest.
 *
 * @group authorization
 * @group api
 */
class SyncPermissionsOnRoleTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'post@v1/permissions/sync';

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
    public function testSyncDuplicatedPermissionsToRole(): void
    {
        $permissionA = factory(Permission::class)->create(['display_name' => 'AAA']);
        $permissionB = factory(Permission::class)->create(['display_name' => 'BBB']);

        $roleA = factory(Role::class)->create();
        $roleA->givePermissionTo($permissionA);

        $data = [
            'role_id'         => $roleA->getHashedKey(),
            'permissions_ids' => [$permissionA->getHashedKey(), $permissionB->getHashedKey()],
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permissionB->id,
            'role_id'       => $roleA->id,
        ]);
    }
}
