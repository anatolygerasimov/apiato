<?php

declare(strict_types=1);

namespace App\Containers\User\Tests\Unit;

use App\Containers\User\Actions\RegisterUserAction;
use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;
use App\Containers\User\UI\API\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;

/**
 * Class CreateUserTest.
 *
 * @group user
 * @group unit
 */
class RegisterUserTest extends TestCase
{
    /**
     * @test
     */
    public function testCreateUser(): void
    {
        $data = [
            'email'    => 'Test@test.test',
            'password' => 'so-secret',
            'username' => 'Test',
        ];

        Event::fake();

        $transporter = new RegisterUserRequest($data);
        $action      = App::make(RegisterUserAction::class);
        $user        = $action->run($transporter);

        // asset the returned object is an instance of the User
        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals($user->username, $data['username']);
    }
}
