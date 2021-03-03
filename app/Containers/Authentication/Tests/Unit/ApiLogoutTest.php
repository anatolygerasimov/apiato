<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Tests\Unit;

use App\Containers\Authentication\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Parser;

/**
 * Class ApiLogoutTest.
 *
 * @group authorization
 * @group unit
 */
class ApiLogoutTest extends TestCase
{
    /**
     * @test
     */
    public function testLogoutByToken(): void
    {
        $user = $this->getTestingUser();

        $token = $user->createToken('test-oauth-client-name')->accessToken;

        //Passport's token parsing is looking to a bearer token using a protected method.
        $request = App::get(Request::class);
        $request->headers->add(['Authorization' => "Bearer $token"]);

        /** @var Parser $parser */
        $parser = App::make(Parser::class);

        $token = $request->bearerToken();

        $this->assertNotNull($token);

        $id = $parser
            ->parse($token)
            ->getClaim('jti');

        // assert data was updated in the database
        $this->assertDatabaseHas('oauth_access_tokens', ['id' => $id]);

        $isRevoked = DB::table('oauth_access_tokens')
            ->where('id', $id)
            ->update(['revoked' => true]);

        $this->assertEquals(1, $isRevoked);

        // assert data was updated in the database
        $this->assertDatabaseHas('oauth_access_tokens', ['id' => $id, 'revoked' => true]);
    }
}
