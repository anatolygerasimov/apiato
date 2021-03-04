<?php

declare(strict_types=1);

namespace App\Containers\Settings\Models;

use App\Ship\Core\Traits\EagerLoadPivotBuilder;
use App\Ship\Parents\Models\Model;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Setting.
 *
 * @property int    $id
 * @property string $key
 * @property string $value
 *
 * @method static EagerLoadPivotBuilder|Setting newModelQuery()
 * @method static EagerLoadPivotBuilder|Setting newQuery()
 * @method static EagerLoadPivotBuilder|Setting query()
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereKey($value)
 * @method static Builder|Setting whereValue($value)
 * @mixin Eloquent
 */
class Setting extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];
}
