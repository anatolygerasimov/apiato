<?php

namespace App\Containers\Payment\Models;

use App\Ship\Core\Traits\EagerLoadPivotBuilder;
use App\Ship\Parents\Models\Model;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Class PaymentAccount.
 *
 * @property int                                               $id
 * @property string|null                                       $name
 * @property string                                            $accountable_type
 * @property int                                               $accountable_id
 * @property int                                               $user_id
 * @property Carbon|null                                       $created_at
 * @property Carbon|null                                       $updated_at
 * @property Carbon|null                                       $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|Eloquent $accountable
 *
 * @method static EagerLoadPivotBuilder|PaymentAccount newModelQuery()
 * @method static EagerLoadPivotBuilder|PaymentAccount newQuery()
 * @method static Builder|PaymentAccount onlyTrashed()
 * @method static EagerLoadPivotBuilder|PaymentAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount whereAccountableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount whereAccountableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentAccount whereUserId($value)
 * @method static Builder|PaymentAccount withTrashed()
 * @method static Builder|PaymentAccount withoutTrashed()
 * @mixin Eloquent
 */
class PaymentAccount extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'accountable_id',
        'accountable_type',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
    ];

    public function accountable(): MorphTo
    {
        return $this->morphTo();
    }
}
