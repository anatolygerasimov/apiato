<?php

namespace App\Ship\Parents\Models;

use App\Ship\Core\Abstracts\Models\UserModel as AbstractUserModel;
use App\Ship\Core\Traits\EagerLoadPivotTrait;
use App\Ship\Core\Traits\HashIdTrait;
use App\Ship\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class UserModel.
 */
abstract class UserModel extends AbstractUserModel
{
    use Notifiable;
    use SoftDeletes;
    use HashIdTrait;
    use HasApiTokens;
    use HasResourceKeyTrait;
    use HasFactory;
    use EagerLoadPivotTrait;
}
