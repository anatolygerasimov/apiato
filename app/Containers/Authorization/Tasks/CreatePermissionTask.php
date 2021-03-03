<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\Authorization\Models\Permission;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\App;

/**
 * Class CreatePermissionTask.
 */
class CreatePermissionTask extends Task
{
    protected PermissionRepository $repository;

    /**
     * CreatePermissionTask constructor.
     */
    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $name, ?string $description = null, ?string $displayName = null, ?string $guardName = null): Permission
    {
        App::get('cache')->forget(config('permission.cache.key'));

        $guardName ??= config('auth.defaults.guard');

        try {
            $permission = $this->repository->create([
                'name'         => $name,
                'description'  => $description,
                'display_name' => $displayName,
                'guard_name'   => $guardName,
            ]);
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }

        return $permission;
    }
}
