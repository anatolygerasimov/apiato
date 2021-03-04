<?php

namespace App\Containers\Stripe\Models;

use App\Containers\Payment\Models\AbstractPaymentAccount;
use App\Containers\Payment\Models\PaymentAccount;
use App\Ship\Core\Traits\EagerLoadPivotBuilder;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * Class StripeAccount.
 *
 * @property int                      $id
 * @property string                   $customer_id
 * @property string|null              $card_id
 * @property string|null              $card_funding
 * @property string|null              $card_last_digits
 * @property string|null              $card_fingerprint
 * @property Carbon|null              $created_at
 * @property Carbon|null              $updated_at
 * @property Carbon|null              $deleted_at
 * @property-read PaymentAccount|null $paymentAccount
 *
 * @method static EagerLoadPivotBuilder|StripeAccount newModelQuery()
 * @method static EagerLoadPivotBuilder|StripeAccount newQuery()
 * @method static Builder|StripeAccount onlyTrashed()
 * @method static EagerLoadPivotBuilder|StripeAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|StripeAccount whereCardFingerprint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeAccount whereCardFunding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeAccount whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeAccount whereCardLastDigits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeAccount whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StripeAccount whereUpdatedAt($value)
 * @method static Builder|StripeAccount withTrashed()
 * @method static Builder|StripeAccount withoutTrashed()
 * @mixin Eloquent
 */
class StripeAccount extends AbstractPaymentAccount
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'card_id',
        'card_funding',
        'card_last_digits',
        'card_fingerprint',
    ];

    /**
     * The dates attributes.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return string
     */
    public function getPaymentGatewayReadableName()
    {
        return 'Stripe';
    }

    /**
     * @return string
     */
    public function getPaymentGatewaySlug()
    {
        return 'stripe';
    }
}
