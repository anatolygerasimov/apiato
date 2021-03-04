<?php

namespace App\Ship\Parents\Models;

use App\Ship\Core\Abstracts\Models\Pivot as AbstractPivot;
use App\Ship\Core\Traits\HashIdTrait;
use App\Ship\Core\Traits\HasResourceKeyTrait;

/**
 * Class Pivot
 */
abstract class Pivot extends AbstractPivot
{
    use HashIdTrait;
    use HasResourceKeyTrait;

//    use HasFactory;
//    use EagerLoadPivotTrait;
}
