<?php

namespace App\Ship\Core\Traits;

use DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Validator;

/**
 * Class ValidationTrait.
 */
trait ValidationTrait
{
    /**
     * Extend the default Laravel validation rules.
     */
    public function extendValidationRules()
    {
        // Validate String contains no space.
        Validator::extend('no_spaces', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\S*$/u', $value);
        }, 'String :attribute should not contain space.');

        // Validate composite unique ID.
        // Usage: unique_composite:table,this-attribute-column,the-other-attribute-column,?the-other-attribute-value
        // Example:    'values'               => 'required|unique_composite:item_variant_values,value,item_variant_name_id,?item_variant_name_value',
        //             'item_variant_name_id' => 'required',
        Validator::extend('unique_composite', function ($attribute, $value, $parameters, $validator) {
            $queryBuilder = DB::table($parameters[0]);

            $queryBuilder = is_array($value) ? $queryBuilder->whereIn($parameters[1],
                $value) : $queryBuilder->where($parameters[1], $value);

            $queryBuilder->where($parameters[2], $parameters[3] ?? $validator->getData()[$parameters[2]]);

            $queryResult = $queryBuilder->get();

            return $queryResult->isEmpty();
        }, 'The :attribute field must be unique.');

        // Validate composite unique ID but exclude row where the-attribute-exclude = the-attribute-exclude-value.
        // Usage: unique_composite_except:table,this-attribute-column,the-other-attribute-column,?the-other-attribute-value,?[the-attribute-exclude,the-attribute-exclude-value]
        // Example:    'values'               => 'required|unique_composite:item_variant_values,value,item_variant_name_id,?item_variant_name_value',?the-attribute-exclude,?the-attribute-exclude-value,
        //             'item_variant_name_id' => 'required',
        Validator::extend('unique_composite_except', function ($attribute, $value, $parameters, $validator) {
            $queryBuilder = DB::table($parameters[0]);

            $queryBuilder = is_array($value) ? $queryBuilder->whereIn($parameters[1],
                $value) : $queryBuilder->where($parameters[1], $value);

            $queryBuilder->where($parameters[2], $parameters[3] ?? $validator->getData()[$parameters[2]]);

            if (isset($parameters[4]) && isset($parameters[5])) {
                $queryBuilder->where($parameters[4], '<>', $parameters[5]);
            }

            $queryResult = $queryBuilder->get();

            return $queryResult->isEmpty();
        }, 'The :attribute field must be unique.');

        /*
         * Boolean validation does not accept "true" and "false", this extend default
         */
        Validator::extend('to_boolean', function ($attribute, $value, $parameters, $validator) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
        }, 'The :attribute field must be true or false.');

        /*
         * Boolean validation only accepts "true"
         */
        Validator::extend('accepted_boolean', function ($attribute, $value, $parameters, $validator) {
            $acceptable = ['1', 1, true, 'true'];

            return in_array($value, $acceptable, true);
        }, 'The :attribute only accepts "true".');

        /*
         * Validate table by attr for current user
         *
         * @return \Illuminate\Validation\Rules\Exists
         * @example ['filled', Rule::existsByUser('screens', 'id')]
         */
        Rule::macro('existsByUser', static fn (string $table, string $column): Exists => Rule::Exists($table, $column)->where('user_id', request()->user()->id));

        /*
         * Validate only active records in a table by attr for the current user
         *
         * @return \Illuminate\Validation\Rules\Exists
         * @example ['filled', Rule::existsActiveRecords('screens', 'id')]
         */
        Rule::macro('existsActiveRecords', static fn (string $table, string $column): Exists => Rule::existsByUser($table, $column)->where('is_active', true));
    }
}
