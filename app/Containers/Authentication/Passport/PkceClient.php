<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Passport;

use Laravel\Passport\Client as BaseClient;

class PkceClient extends BaseClient
{
    /**
     * @inheritdoc
     */
    public function skipsAuthorization()
    {
        return $this->firstParty();
    }
}
