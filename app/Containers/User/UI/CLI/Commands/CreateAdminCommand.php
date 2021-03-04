<?php

declare(strict_types=1);

namespace App\Containers\User\UI\CLI\Commands;

use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Commands\ConsoleCommand;
use App\Ship\Transporters\DataTransporter;

/**
 * Class CreateAdminCommand.
 */
class CreateAdminCommand extends ConsoleCommand
{
    /**
     * @var string
     */
    protected $signature = 'blocks:create:admin';

    /**
     * @var string
     */
    protected $description = 'Create a new User with the ADMIN role';

    /**
     * @return void
     */
    public function handle()
    {
        $username             = $this->ask('Enter the username for this user');
        $email                = $this->ask('Enter the email address of this user');
        $password             = $this->secret('Enter the password for this user');
        $passwordConfirmation = $this->secret('Please confirm the password');

        if ($password !== $passwordConfirmation) {
            $this->error('Passwords do not match - exiting!');

            return;
        }

        $dataTransporter = new DataTransporter([
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ]);

        $user = Apiato::call('Orchid@CreateAdminAction', [$dataTransporter]);

        $this->info("Admin {$user->email} was successfully created");
    }
}
