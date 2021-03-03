<?php

namespace App\Ship\Core\Traits;

use Artisan;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\PersonalAccessClient;

/**
 * Class TestCaseTrait
 */
trait TestCaseTrait
{
    /**
     * Migrate the database.
     */
    public function migrateDatabase()
    {
        Artisan::call('migrate');
    }

    /**
     * Equivalent to passport:install but enough to run the tests
     */
    public function setupPassportOAuth2()
    {
        $client = (new ClientRepository())->createPersonalAccessClient(
            null,
            'Testing Personal Access Client',
            'http://localhost'
        );

        $accessClient            = new PersonalAccessClient();
        $accessClient->client_id = $client->id;
        $accessClient->save();
    }
}
