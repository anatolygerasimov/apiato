<?php

namespace App\Ship\Core\Traits;

/**
 * Class StateKeeperTrait
 */
trait StateKeeperTrait
{
    /**
     * Stores Data of any kind during the request life cycle.
     * This helps related Actions can share data from different steps.
     *
     * @var  array
     */
    public $stateKeeperStates = [];

    /**
     * @param array $data
     *
     * @return  $this
     */
    public function keep(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->stateKeeperStates[$key] = $value;
        }

        return $this;
    }

    /**
     * @param $key
     *
     * @return  mixed
     */
    public function retrieve($key)
    {
        return $this->stateKeeperStates[$key];
    }
}
