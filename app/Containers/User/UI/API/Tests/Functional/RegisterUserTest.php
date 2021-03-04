<?php

declare(strict_types=1);

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\SystemStatus\Exceptions\FallbackRouteNotFoundException;
use App\Containers\User\Tests\ApiTestCase;

/**
 * Class RegisterUserTest.
 *
 * @group user
 * @group api
 */
class RegisterUserTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'post@v1/register';

    /**
     * @var bool
     */
    protected $auth = false;

    /**
     * @var array
     */
    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    /**
     * @test
     */
    public function testRegisterNewUserWithCredentials(): void
    {
        $data = [
            'email'                 => 'apiato@mail.test',
            'username'              => 'Apiato',
            'password'              => 'secretpass',
            'password_confirmation' => 'secretpass',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        $withConfirmEmail = config('authentication-container.require_email_confirmation');

        // assert response status is correct
        $response->assertStatus($withConfirmEmail ? 202 : 200);

        if ($withConfirmEmail) {
            $this->assertResponseContainKeys(['message']);
        } else {
            $this->assertResponseContainKeyValue([
                'email'    => $data['email'],
                'username' => $data['username'],
            ]);
        }

        // assert the data is stored in the database
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    /**
     * @test
     */
    public function testRegisterNewUserUsingGetVerb(): void
    {
        $data = [
            'email'    => 'apiato@mail.test',
            'username' => 'Apiato',
            'password' => 'secret',
        ];

        // send the HTTP request
        $response = $this->endpoint('get@v1/register')->makeCall($data);

        $message = (new FallbackRouteNotFoundException())->getMessage();
        $code    = (new FallbackRouteNotFoundException())->getStatusCode();

        // assert response status is correct
        $response->assertStatus($code);

        $this->assertResponseContainKeyValue(['message' => $message]);
    }

    /**
     * @test
     */
    public function testRegisterExistingUser(): void
    {
        $userDetails = [
            'email'    => 'apiato@mail.test',
            'username' => 'Apiato',
            'password' => 'secret',
        ];

        // get the logged in user (create one if no one is logged in)
        $this->getTestingUser($userDetails);

        $data = [
            'email'    => $userDetails['email'],
            'username' => $userDetails['username'],
            'password' => $userDetails['password'],
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);

        $this->assertValidationErrorContain([
            'email' => 'The email has already been taken.',
        ]);
    }

    /**
     * @test
     */
    public function testRegisterNewUserWithoutEmail(): void
    {
        $data = [
            'username' => 'Apiato',
            'password' => 'secret',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);

        // assert response contain the correct message
        $this->assertValidationErrorContain([
            'email' => 'The email field is required.',
        ]);
    }

    /**
     * @test
     */
    public function testRegisterNewUserWithoutName(): void
    {
        $data = [
            'email'    => 'apiato@mail.test',
            'password' => 'secret',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);

        // assert response contain the correct message
        $this->assertValidationErrorContain([
            'username' => 'The username field is required.',
        ]);
    }

    /**
     * @test
     */
    public function testRegisterNewUserWithoutPassword(): void
    {
        $data = [
            'email'    => 'apiato@mail.test',
            'username' => 'Apiato',
        ];

        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);

        // assert response contain the correct message
        $this->assertValidationErrorContain([
            'password' => 'The password field is required.',
        ]);
    }

    /**
     * @test
     */
    public function testRegisterNewUserWithInvalidEmail(): void
    {
        $data = [
            'email'    => 'missing-at.test',
            'username' => 'Apiato',
            'password' => 'secret',
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(422);

        // assert response contain the correct message
        $this->assertValidationErrorContain([
            'email' => 'The email must be a valid email address.',
        ]);
    }
}
