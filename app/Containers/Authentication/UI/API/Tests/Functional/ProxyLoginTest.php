<?php

declare(strict_types=1);

namespace App\Containers\Authentication\UI\API\Tests\Functional;

use App\Containers\Authentication\Tests\ApiTestCase;
use Illuminate\Support\Facades\DB;

/**
 * Class ProxyLoginTest.
 *
 * @group authorization
 * @group api
 */
class ProxyLoginTest extends ApiTestCase
{
    /**
     * @var string
     */
    protected $endpoint = 'post@v1/login';

    /**
     * @var array
     */
    protected $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    private bool $testingFilesCreated = false;

    /**
     * @test
     */
    public function testClientApiProxyLogin(): void
    {
        // create data to be used for creating the testing user and to be sent with the post request
        $data = [
            'email'    => 'testing@mail.com',
            'password' => 'testingpass',
        ];

        $user = $this->getTestingUser($data);
        $this->actingAs($user, 'web');

        $clientId     = '100';
        $clientSecret = 'XXp8x4QK7d3J9R7OVRXWrhc19XPRroHTTKIbY8XX';

        // create client
        DB::table('oauth_clients')->insert([
            [
                'id'                     => $clientId,
                'secret'                 => $clientSecret,
                'name'                   => 'Testing',
                'redirect'               => 'http://localhost',
                'password_client'        => '1',
                'personal_access_client' => '0',
                'revoked'                => '0',
            ],
        ]);

        // make the clients credentials available as env variables
        config(['authentication-container.clients.api.user.id' => $clientId]);
        config(['authentication-container.clients.api.user.secret' => $clientSecret]);

        // create testing oauth keys files
        $publicFilePath  = $this->createTestingKey('oauth-public.key');
        $privateFilePath = $this->createTestingKey('oauth-private.key');

        $response = $this->makeCall($data);

        $response->assertStatus(200);

        $response->assertCookie('refreshToken');

        $this->assertResponseContainKeyValue([
            'token_type' => 'Bearer',
        ]);

        $this->assertResponseContainKeys(['expires_in', 'access_token']);

        // delete testing keys files if they were created for this test
        if ($this->testingFilesCreated) {
            unlink($publicFilePath);
            unlink($privateFilePath);
        }
    }

    /**
     * @test
     */
    public function testClientApiProxyUnconfirmedLogin(): void
    {
        // create data to be used for creating the testing user and to be sent with the post request
        $data = [
            'email'             => 'testing2@mail.com',
            'password'          => 'testingpass',
            'email_verified_at' => null,
        ];

        $user = $this->getTestingUser($data);
        $this->actingAs($user, 'web');

        $clientId     = '100';
        $clientSecret = 'XXp8x4QK7d3J9R7OVRXWrhc19XPRroHTTKIbY8XX';

        // create client
        DB::table('oauth_clients')->insert([
            [
                'id'                     => $clientId,
                'secret'                 => $clientSecret,
                'name'                   => 'Testing',
                'redirect'               => 'http://localhost',
                'password_client'        => '1',
                'personal_access_client' => '0',
                'revoked'                => '0',
            ],
        ]);

        // make the clients credentials available as env variables
        config(['authentication-container.clients.api.user.id' => $clientId]);
        config(['authentication-container.clients.api.user.secret' => $clientSecret]);

        // create testing oauth keys files
        $publicFilePath  = $this->createTestingKey('oauth-public.key');
        $privateFilePath = $this->createTestingKey('oauth-private.key');

        $response = $this->makeCall($data);

        if (config('authentication-container.require_email_confirmation')) {
            $response->assertStatus(409);
        } else {
            $response->assertStatus(200);
        }

        // delete testing keys files if they were created for this test
        if ($this->testingFilesCreated) {
            unlink($publicFilePath);
            unlink($privateFilePath);
        }
    }

    public function testLoginWithNameAttribute(): void
    {
        // create data to be used for creating the testing user and to be sent with the post request
        $data = [
            'email'    => 'testing@mail.com',
            'password' => 'testingpass',
            'username' => 'username',
        ];

        $user = $this->getTestingUser($data);
        $this->actingAs($user, 'web');

        $clientId     = '100';
        $clientSecret = 'XXp8x4QK7d3J9R7OVRXWrhc19XPRroHTTKIbY8XX';

        // create client
        DB::table('oauth_clients')->insert([
            [
                'id'                     => $clientId,
                'secret'                 => $clientSecret,
                'name'                   => 'Testing',
                'redirect'               => 'http://localhost',
                'password_client'        => '1',
                'personal_access_client' => '0',
                'revoked'                => '0',
            ],
        ]);

        // make the clients credentials available as env variables
        config(['authentication-container.clients.api.user.id' => $clientId]);
        config(['authentication-container.clients.api.user.secret' => $clientSecret]);

        // specifically allow to login with "username" attribute
        config(['authentication-container.login.attributes' => [
            'email'    => ['email'],
            'username' => [],
        ]]);

        // create testing oauth keys files
        $publicFilePath  = $this->createTestingKey('oauth-public.key');
        $privateFilePath = $this->createTestingKey('oauth-private.key');

        $request = [
            'password' => 'testingpass',
            'username' => 'username',
        ];

        $response = $this->makeCall($request);

        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'token_type' => 'Bearer',
        ]);

        $this->assertResponseContainKeys(['expires_in', 'access_token', 'refresh_token']);

        // delete testing keys files if they were created for this test
        if ($this->testingFilesCreated) {
            unlink($publicFilePath);
            unlink($privateFilePath);
        }
    }

    private function createTestingKey(string $fileName): string
    {
        $filePath = storage_path($fileName);

        if (!file_exists($filePath)) {
            $keysStubDirectory = __DIR__ . '/Stubs/';

            copy($keysStubDirectory . $fileName, $filePath);

            $this->testingFilesCreated = true;
        }

        return $filePath;
    }
}
