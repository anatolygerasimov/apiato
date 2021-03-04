<?php

declare(strict_types=1);

namespace App\Containers\User\Models;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\Traits\AuthenticationTrait;
use App\Containers\Authorization\Traits\AuthorizationTrait;
use App\Containers\Payment\Contracts\ChargeableInterface;
use App\Containers\Payment\Models\PaymentAccount;
use App\Containers\Payment\Traits\ChargeableTrait;
use App\Containers\User\Notifications\ResetPasswordNotification;
use App\Containers\User\Notifications\VerifyEmailNotification;
use App\Containers\User\Traits\HasUserAvatar;
use App\Ship\Core\Traits\EagerLoadPivotBuilder;
use App\Ship\Parents\Models\UserModel;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Laravel\Passport\Client;
use Laravel\Passport\Token;

/**
 * Class User.
 *
 * @property int                                                        $id
 * @property int|null                                                   $default_process_id Indicates if it's a default process
 * @property int|null                                                   $default_screen_id  Indicates if it's a default screen
 * @property int|null                                                   $company_id         User company
 * @property string|null                                                $first_name
 * @property string|null                                                $last_name
 * @property string                                                     $email
 * @property string                                                     $username
 * @property string|null                                                $avatar             Avatar path
 * @property string                                                     $password
 * @property Carbon|null                                                $email_verified_at  Email confirmed date
 * @property bool                                                       $is_client          Indicates it's admin or it's client
 * @property string|null                                                $data_source        Enum of sources ("UserUploaded", "Bloomberg", "Morningstar") to fetch ticket financial data
 * @property string|null                                                $remember_token     OAuth2 token
 * @property Carbon|null                                                $last_login_at
 * @property string|null                                                $last_login_ip
 * @property Carbon|null                                                $created_at
 * @property Carbon|null                                                $updated_at
 * @property Carbon|null                                                $deleted_at
 * @property-read Collection|Client[]                                   $clients
 * @property-read int|null                                              $clients_count
 * @property-read string                                                $avatar_url
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null                                              $notifications_count
 * @property-read Collection|PaymentAccount[]                           $paymentAccounts
 * @property-read int|null                                              $payment_accounts_count
 * @property-read Collection|Permission[]                               $permissions
 * @property-read int|null                                              $permissions_count
 * @property-read Collection|Role[]                                     $roles
 * @property-read int|null                                              $roles_count
 * @property-read Collection|Token[]                                    $tokens
 * @property-read int|null                                              $tokens_count
 *
 * @method static Builder|User countByDays($startDate = null, $stopDate = null, $dateColumn = 'created_at')
 * @method static Builder|User countForGroup($groupColumn)
 * @method static Builder|User defaultSort($column, $direction = 'asc')
 * @method static EagerLoadPivotBuilder|User newModelQuery()
 * @method static EagerLoadPivotBuilder|User newQuery()
 * @method static Builder|UserModel permission($permissions)
 * @method static EagerLoadPivotBuilder|User query()
 * @method static Builder|UserModel role($roles, $guard = null)
 * @method static Builder|User sumByDays($value, $startDate = null, $stopDate = null, $dateColumn = 'created_at')
 * @method static Builder|User valuesByDays($value, $startDate = null, $stopDate = null, $dateColumn = 'created_at')
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCompanyId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDataSource($value)
 * @method static Builder|User whereDefaultProcessId($value)
 * @method static Builder|User whereDefaultScreenId($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsClient($value)
 * @method static Builder|User whereLastLoginAt($value)
 * @method static Builder|User whereLastLoginIp($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @mixin Eloquent
 */
class User extends UserModel implements ChargeableInterface, MustVerifyEmail
{
    use AuthenticationTrait;
    use AuthorizationTrait;
    use ChargeableTrait;
    use HasUserAvatar;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'default_process_id',
        'default_screen_id',
        'company_id',
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar',
        'data_source',
        'is_client',
        'email_verified_at',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar_url',
    ];

    /**
     * @var array<string, string|class-string<\datetime>>
     */
    protected $casts = [
        'is_client'          => 'boolean',
        'default_process_id' => 'integer',
        'default_screen_id'  => 'integer',
        'company_id'         => 'integer',
        'last_login_at'      => 'datetime',
        'email_verified_at'  => 'datetime',
        'deleted_at'         => 'datetime',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'username',
        'email',
        'last_login_at',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'username',
        'email',
        'last_login_at',
        'updated_at',
        'created_at',
    ];

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // Relation

    public function paymentAccounts(): HasMany
    {
        return $this->hasMany(PaymentAccount::class);
    }
}
