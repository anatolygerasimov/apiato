<?php

declare(strict_types=1);

namespace App\Containers\Authorization\UI\CLI\Commands;

use App\Containers\Authorization\Exceptions\RoleNotFoundException;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Commands\ConsoleCommand;

/**
 * Class GiveAllPermissionsToRoleCommand.
 */
class GiveAllPermissionsToRoleCommand extends ConsoleCommand
{
    /**
     * @var string
     */
    protected $signature = 'blocks:permissions:toRole {role} {guard?}';

    /**
     * @var string
     */
    protected $description = 'Give all system Permissions to a specific Role and Guard.';

    /**
     * @void
     */
    public function handle(): void
    {
        /** @var string $roleName */
        $roleName  = $this->argument('role');
        $guardName = $this->argument('guard') ?? config('auth.defaults.guard');

        $allPermissions = Apiato::call('Authorization@GetAllPermissionsTask', [true], [['filterByGuard' => [$guardName]]]);

        $role = Apiato::call('Authorization@FindRoleTask', [$roleName]);

        if (!$role) {
            throw new RoleNotFoundException("Role $roleName is not found!");
        }

        $allPermissionsNames = $allPermissions->pluck('name')->toArray();

        $role->syncPermissions($allPermissionsNames);

        $permissionsString = implode(' - ', $allPermissionsNames);

        $this->info("Gave the Role ({$roleName}) the following Permissions: {$permissionsString}.");
    }
}
