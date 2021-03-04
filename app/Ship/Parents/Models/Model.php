<?php

namespace App\Ship\Parents\Models;

use App\Ship\Core\Abstracts\Models\Model as AbstractModel;
use App\Ship\Core\Traits\EagerLoadPivotTrait;
use App\Ship\Core\Traits\HashIdTrait;
use App\Ship\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Model.
 */
abstract class Model extends AbstractModel
{
    use HashIdTrait;
    use HasResourceKeyTrait;
    use HasFactory;
    use EagerLoadPivotTrait;
}
