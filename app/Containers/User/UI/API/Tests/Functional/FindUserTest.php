<?php

declare(strict_types=1);

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Tests\ApiTestCase;

/**
 * Class FindUsersTest.
 *
 * @group user
 * @group api
 */
class FindUserTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'get@v1/users/{id}';

    /**
     * @var array
     */
    protected $access = [
        'roles'       => '',
        'permissions' => 'search-users',
    ];

    /**
     * @test
     */
    public function testFindUser(): void
    {
        $admin = $this->getTestingUser();

        // send the HTTP request
        $response = $this->injectId($admin->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($admin->username, $responseContent->data->username);
    }

    /**
     * @test
     */
    public function testFindFilteredUserResponse(): void
    {
        $admin = $this->getTestingUser();

        // send the HTTP request
        $response = $this->injectId($admin->id)->endpoint($this->endpoint . '?filter=email;username')->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($admin->username, $responseContent->data->username);
        $this->assertEquals($admin->email, $responseContent->data->email);

        // convert response to array
        $responseArray = $response->json();

        $this->assertNotContains('id', $responseArray);
    }

    /**
     * @test
     */
    public function testFindUserWithRelation(): void
    {
        $admin = $this->getTestingUser();

        // send the HTTP request
        $response = $this->injectId($admin->id)->endpoint($this->endpoint . '?include=roles')->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($admin->email, $responseContent->data->email);

        $this->assertNotNull($responseContent->data->roles);
    }
}
