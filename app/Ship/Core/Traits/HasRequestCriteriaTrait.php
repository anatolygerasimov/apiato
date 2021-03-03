<?php

namespace App\Ship\Core\Traits;

use App\Ship\Core\Abstracts\Repositories\Repository;
use App\Ship\Core\Exceptions\CoreInternalErrorException;
use App\Ship\Core\Abstracts\Criterias\PrettusRequestCriteria;

/**
 * Trait HasRequestCriteriaTrait
 */
trait HasRequestCriteriaTrait
{
    /**
     * Adds the PrettusRequestCriteria to a Repository
     *
     * @param null $repository
     */
    public function addRequestCriteria($repository = null)
    {
        if (!config('apiato.requests.automatically-apply-request-criteria', false)) {
            $validatedRepository = $this->validateRepository($repository);
            $validatedRepository->pushCriteria(app(PrettusRequestCriteria::class));
        }
    }

    /**
     * Removes the PrettusRequestCriteria from a Repository
     *
     * @param null $repository
     */
    public function removeRequestCriteria($repository = null)
    {
        $validatedRepository = $this->validateRepository($repository);

        $validatedRepository->popCriteria(PrettusRequestCriteria::class);
    }

    /**
     * Validates, if the given Repository exists or uses $this->repository on the Task/Action to apply functions
     *
     * @param $repository
     *
     * @return mixed
     * @throws CoreInternalErrorException
     */
    private function validateRepository($repository)
    {
        $validatedRepository = $repository;

        // check if we have a "custom" repository
        if (null === $repository) {
            if (!isset($this->repository)) {
                throw new CoreInternalErrorException('No protected or public accessible repository available');
            }
            $validatedRepository = $this->repository;
        }

        // check, if the validated repository is null
        if (null === $validatedRepository) {
            throw new CoreInternalErrorException();
        }

        // check if it is a Repository class
        if (!($validatedRepository instanceof Repository)) {
            throw new CoreInternalErrorException();
        }

        return $validatedRepository;
    }
}
