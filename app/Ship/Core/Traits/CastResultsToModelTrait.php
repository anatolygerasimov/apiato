<?php

namespace App\Ship\Core\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\Paginator;

/**
 * Class CastResultsToModelTrait
 */
trait CastResultsToModelTrait
{
    /**
     * Casts a given array or collection to this model class if it isn't already
     *
     * @param Collection|Paginator|array $results
     *
     * @return Collection|Paginator
     */
    static function castResults($results)
    {
        /**
         * If the object being passed in is a paginator, let's create another paginator with the updated results
         */
        $isPaginator   = is_a($results, AbstractPaginator::class);
        $resultsToCast = $isPaginator ? $results->items() : $results;
        $castResults   = $resultsToCast;

        /**
         * Item is an array. Check to make sure each item within that array is of the correct type, and cast if not
         */
        if (is_array($resultsToCast)) {
            $castResults = new Collection();

            foreach ($resultsToCast as $objectToCast) {

                if (is_a($objectToCast, self::class)) {
                    $castResults->push($objectToCast);
                    continue;
                }

                $castResults->push((new static)->newFromBuilder($objectToCast));
            }
        }

        /**
         * If the original object was a paginator, then re-create it
         */
        if ($isPaginator) {
            $paginatorClass = get_class($results);
            $newPaginator   = new $paginatorClass($resultsToCast, $results->total(), $results->perPage(), $results->currentPage());
            $newPaginator->setPath($results->resolveCurrentPath());
            return $newPaginator;
        }

        return $castResults;
    }
}
