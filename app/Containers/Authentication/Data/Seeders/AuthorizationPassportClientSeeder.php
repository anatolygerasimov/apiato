<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Data\Seeders;

use App\Ship\Parents\Seeders\Seeder;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;

/**
 * Class AuthorizationPassportClientSeeder.
 */
class AuthorizationPassportClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPassportClient(1, 'Blocks Password Grant Client', 'q1iOysZz1MlaQAaSEifJmoLAgOxETxZ7jB67w7e4', 'users', 'http://localhost', false, true);
        $this->createPassportClient(2, 'Blocks Authorization Code Grant with PKCE', null, null, config('app.url') . '/auth');

        $this->prePopulatedOAuthToken(1, 1);
    }

    private function createPassportClient(?int $id, string $name, ?string $confidential, ?string $provider, string $redirect, bool $personalAccess = false, bool $password = false): void
    {
        $client = Passport::client()->forceFill([
            'id'                     => $id,
            'user_id'                => null,
            'name'                   => $name,
            'secret'                 => $confidential,
            'provider'               => $provider,
            'redirect'               => $redirect,
            'personal_access_client' => $personalAccess,
            'password_client'        => $password,
            'revoked'                => false,
        ]);

        $client->save();
    }

    private function prePopulatedOAuthToken(int $userId, int $clientId): void
    {
        DB::table('oauth_access_tokens')
            ->upsert([
                [
                    'id'         => '33c9328aee0704c899b719bf89741c44f2f8de88a23c647f4d2be0ca477db29f2f6c2dc1cd1a90ef',
                    'user_id'    => $userId,
                    'client_id'  => $clientId,
                    'name'       => null,
                    'scopes'     => '[]',
                    'revoked'    => 0,
                    'expires_at' => now()->addMonths(3),
                ],
                [
                    'id'         => '4c3371049d4a4e15c74189eb0d465b7a368bd841b09f7a146f913a72062312bb77c9af7e47d897fc',
                    'user_id'    => $userId,
                    'client_id'  => $clientId,
                    'name'       => null,
                    'scopes'     => '[]',
                    'revoked'    => 0,
                    'expires_at' => now()->addMonths(3),
                ],
                [
                    'id'         => 'f0363e980b43890985c151c13cc0bac37ee3d6452ebd28a13e10028c9d3d95510cfb5620dffe0300',
                    'user_id'    => $userId,
                    'client_id'  => $clientId,
                    'name'       => null,
                    'scopes'     => '[]',
                    'revoked'    => 0,
                    'expires_at' => now()->addMonths(3),
                ],
            ],
                ['id'],
                ['id', 'user_id', 'client_id', 'scopes', 'revoked', 'expires_at'],
            );

        DB::table('oauth_refresh_tokens')
            ->upsert([
                [
                    'id'              => '0b9137239ec16e5f3c28a9709b42f7df2359ff46f9a74ed429532dc4d5f7da92af204ced999a9819',
                    'access_token_id' => '4c3371049d4a4e15c74189eb0d465b7a368bd841b09f7a146f913a72062312bb77c9af7e47d897fc',
                    'revoked'         => 0,
                    'expires_at'      => now()->addMonths(3),
                ],
                [
                    'id'              => '89135e49b06b4f905a1d58dd60b80ec59e9484071f100ec9c20d3f2f5199edc51aa2320acbdf3365',
                    'access_token_id' => 'f0363e980b43890985c151c13cc0bac37ee3d6452ebd28a13e10028c9d3d95510cfb5620dffe0300',
                    'revoked'         => 0,
                    'expires_at'      => now()->addMonths(3),
                ],
                [
                    'id'              => '9e7ca24c82abb53c0273ed5688aa10fa9afe2bc217971ddd898c7b037d5ff49e14629bdf2ef53232',
                    'access_token_id' => '33c9328aee0704c899b719bf89741c44f2f8de88a23c647f4d2be0ca477db29f2f6c2dc1cd1a90ef',
                    'revoked'         => 0,
                    'expires_at'      => now()->addMonths(3),
                ],
            ],
                ['id'],
                ['id', 'access_token_id', 'revoked', 'expires_at'],
            );
    }
}
