<?php

namespace App\Ship\Parents\Values;

use App\Ship\Core\Traits\HasResourceKeyTrait;
use App\Ship\Core\Abstracts\Values\Value as AbstractValue;

/**
 * Class Value.
 */
abstract class Value extends AbstractValue
{
    use HasResourceKeyTrait;
}
