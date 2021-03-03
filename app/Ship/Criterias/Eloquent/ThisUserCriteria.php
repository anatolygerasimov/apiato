<?php

namespace App\Ship\Criterias\Eloquent;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ThisUserCriteria.
 */
class ThisUserCriteria extends Criteria
{
    private ?int $userId = null;

    public function __construct(?int $userId = null)
    {
        $this->userId = $userId;
    }

    /**
     * @param Builder|Model              $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        $this->userId ??= Auth::user()->id;

        $table = $model->getModel()->getTable();

        return $model->where("{$table}.user_id", '=', $this->userId);
    }
}
