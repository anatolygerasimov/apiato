<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Models;

use App\Containers\User\Models\User;
use App\Ship\Core\Traits\HashIdTrait;
use App\Ship\Core\Traits\HasResourceKeyTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role.
 *
 * @property int                          $id
 * @property string                       $name
 * @property string                       $guard_name
 * @property string|null                  $display_name
 * @property string|null                  $description
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property int                          $level
 * @property Collection|Permission[]      $permissions
 * @property-read int|null                $permissions_count
 * @property-read Collection|User[]       $users
 * @property-read int|null                $users_count
 *
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role permission($permissions)
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereDisplayName($value)
 * @method static Builder|Role whereGuardName($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereLevel($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Role extends SpatieRole
{
    use HashIdTrait;
    use HasResourceKeyTrait;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
        'level',
    ];
}
