<?php

namespace App\Ship\Core\Abstracts\Transformers;

use App\Ship\Core\Exceptions\CoreInternalErrorException;
use App\Ship\Core\Exceptions\UnsupportedFractalIncludeException;
use App\Ship\Core\Foundation\Facades\Apiato;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Config;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract as FractalTransformer;

/**
 * Class Transformer.
 */
abstract class Transformer extends FractalTransformer
{
    /**
     * @return mixed
     */
    public function user()
    {
        return Apiato::call('Authentication@GetAuthenticatedUserTask');
    }

    /**
     * @param $adminResponse
     * @param $clientResponse
     *
     * @return array
     */
    public function ifAdmin($adminResponse, $clientResponse)
    {
        $user = $this->user();

        if (!is_null($user) && $user->hasAdminRole()) {
            return array_merge($clientResponse, $adminResponse);
        }

        return $clientResponse;
    }

    /**
     * @param mixed                       $data
     * @param callable|FractalTransformer $transformer
     * @param null                        $resourceKey
     *
     * @return Item
     */
    public function item($data, $transformer, $resourceKey = null)
    {
        // set a default resource key if none is set
        if (!$resourceKey && $data) {
            $resourceKey = $data->getResourceKey();
        }

        return parent::item($data, $transformer, $resourceKey);
    }

    /**
     * @param mixed                       $data
     * @param callable|FractalTransformer $transformer
     * @param null                        $resourceKey
     *
     * @return Collection
     */
    public function collection($data, $transformer, $resourceKey = null)
    {
        // set a default resource key if none is set
        if (!$resourceKey && $data->isNotEmpty()) {
            $resourceKey = (string) $data->modelKeys()[0];
        }

        return parent::collection($data, $transformer, $resourceKey);
    }

    /**
     * @FIXME : thinking about this method
     * @param Scope  $scope
     * @param string $includeName
     * @param mixed  $data
     *
     * @return ResourceInterface|void
     * @throws CoreInternalErrorException
     * @throws UnsupportedFractalIncludeException
     */
    protected function callIncludeMethod(Scope $scope, $includeName, $data)
    {
        try {
            return parent::callIncludeMethod($scope, $includeName, $data);
        } catch (ErrorException $exception) {
            if (config('apiato.requests.force-valid-includes', true)) {
                throw new UnsupportedFractalIncludeException($exception->getMessage());
            }
        } catch (Exception $exception) {
            throw new CoreInternalErrorException($exception->getMessage());
        }
    }
}
