<?php

namespace App\Containers\Payment\Models;

use App\Ship\Core\Traits\EagerLoadPivotBuilder;
use App\Ship\Parents\Models\Model;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Class PaymentTransaction.
 *
 * @property int         $id
 * @property int         $user_id
 * @property string      $gateway
 * @property string      $transaction_id
 * @property string      $status
 * @property bool        $is_successful
 * @property string      $amount
 * @property string|null $currency
 * @property array|null  $data
 * @property array|null  $custom
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @method static EagerLoadPivotBuilder|PaymentTransaction newModelQuery()
 * @method static EagerLoadPivotBuilder|PaymentTransaction newQuery()
 * @method static Builder|PaymentTransaction onlyTrashed()
 * @method static EagerLoadPivotBuilder|PaymentTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereCustom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereIsSuccessful($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentTransaction whereUserId($value)
 * @method static Builder|PaymentTransaction withTrashed()
 * @method static Builder|PaymentTransaction withoutTrashed()
 * @mixin Eloquent
 */
class PaymentTransaction extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',

        'gateway',
        'transaction_id',
        'status',
        'is_successful',

        'amount',
        'currency',

        'data',
        'custom',
    ];

    /**
     * @var mixed[]
     */
    protected $attributes = [

    ];

    /**
     * @var mixed[]
     */
    protected $hidden = [

    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_successful' => 'boolean',
        'data'          => 'array',
        'custom'        => 'array',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * A resource key to be used by the the JSON API Serializer responses.
     */
    protected string $resourceKey = 'paymenttransactions';
}
