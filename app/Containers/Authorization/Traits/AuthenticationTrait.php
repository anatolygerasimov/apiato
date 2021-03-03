<?php

namespace App\Containers\Authorization\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthenticationTrait.
 */
trait AuthenticationTrait
{
    /**
     * Allows Passport to authenticate users with custom fields.
     *
     * @param string $identifier
     *
     * @return Model|null
     */
    public function findForPassport($identifier)
    {
        $allowedLoginAttributes = config('authentication-container.login.attributes', ['email' => []]);

        /** @var Builder|Model $builder */
        $builder = $this;
        foreach (array_keys($allowedLoginAttributes) as $field) {
            $builder = $builder->orWhere($field, $identifier);
        }

        return $builder->first();
    }
}
