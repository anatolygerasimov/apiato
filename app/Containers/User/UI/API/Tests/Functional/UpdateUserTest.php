<?php

declare(strict_types=1);

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\User\Tests\ApiTestCase;

/**
 * Class UpdateUserTest.
 *
 * @group user
 * @group api
 */
class UpdateUserTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'patch@v1/users/{id}';

    /**
     * @var array
     */
    protected $access = [
        'roles'       => '',
        'permissions' => 'update-users',
    ];

    /**
     * @test
     */
    public function testUpdateExistingUser(): void
    {
        $user = $this->getTestingUser();

        $data = [
            'username' => 'Updated username',
        ];

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'object'   => 'User',
            'email'    => $user->email,
            'username' => $data['username'],
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('users', ['username' => $data['username']]);
    }

    /**
     * @test
     */
    public function testUpdateNonExistingUser(): void
    {
        $data = [
            'username' => 'Updated Username',
        ];

        $fakeUserId = 7777;

        // send the HTTP request
        $response = $this->injectId($fakeUserId)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);
    }

    /**
     * @test
     */
    public function testUpdateExistingUserWithoutData(): void
    {
        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);
    }

    /**
     * @test
     */
    public function testUpdateExistingUserWithEmptyValues(): void
    {
        $user = $this->getTestingUser();

        $data = [
            'username'   => '1',
            'first_name' => '1',
        ];

        // send the HTTP request
        $response = $this->injectId($user->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);

        $this->assertValidationErrorContain([
            // messages should be updated after modifying the validation rules, to pass this test
            'username'   => 'The username must be at least 2 characters.',
            'first_name' => 'The first name must be at least 2 characters.',
        ]);
    }
}
