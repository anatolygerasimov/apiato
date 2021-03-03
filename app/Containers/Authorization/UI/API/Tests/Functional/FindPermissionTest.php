<?php

namespace App\Containers\Authorization\UI\API\Tests\Functional;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Tests\ApiTestCase;

/**
 * Class FindPermissionTest.
 *
 * @group authorization
 * @group api
 */
class FindPermissionTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'get@v1/permissions/{id}';

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
    public function testFindPermissionById(): void
    {
        $permissionA = factory(Permission::class)->create();

        // send the HTTP request
        $response = $this->injectId($permissionA->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($permissionA->name, $responseContent->data->name);
    }
}
