<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\Tests\ApiTestCase;

/**
 * Class DeleteRoleTest.
 *
 * @group authorization
 * @group api
 */
class DeleteRoleTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'delete@v1/roles/{id}';

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
    public function testDeleteExistingRole(): void
    {
        $role = factory(Role::class)->create();

        // send the HTTP request
        $response = $this->injectId($role->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(204);
    }
}
