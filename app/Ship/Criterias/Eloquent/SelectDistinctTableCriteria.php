<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class SelectDistinctTableCriteria.
 */
class SelectDistinctTableCriteria extends Criteria
{
    private ?array $fields = null;

    public function __construct(?array $fields = null)
    {
        $this->fields = $fields;
    }

    /**
     * @param Builder|Model              $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        $table = $model->getModel()->getTable();

        $fields = empty($this->fields) ? "{$table}.*" : array_map(fn($field) => "{$table}.{$field}", $this->fields);

        return $model->select($fields)->distinct();
    }
}
