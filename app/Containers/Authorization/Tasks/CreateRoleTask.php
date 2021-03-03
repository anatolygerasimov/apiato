<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\RoleRepository;
use App\Containers\Authorization\Models\Role;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\App;

/**
 * Class CreateRoleTask.
 */
class CreateRoleTask extends Task
{
    protected RoleRepository $repository;

    /**
     * CreateRoleTask constructor.
     */
    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $name, ?string $description = null, ?string $displayName = null, ?string $guardName = null, int $level = 0): Role
    {
        App::get('cache')->forget(config('permission.cache.key'));

        $guardName ??= config('auth.defaults.guard');

        try {
            $role = $this->repository->create([
                'name'         => strtolower($name),
                'description'  => $description,
                'display_name' => $displayName,
                'guard_name'   => $guardName,
                'level'        => $level,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }

        return $role;
    }
}
