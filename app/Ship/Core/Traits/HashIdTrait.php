<?php

namespace App\Ship\Core\Traits;

use App\Ship\Exceptions\IncorrectIdException;
use App\Ship\Parents\Models\Model;
use Illuminate\Routing\Router;
use Route;
use Vinkla\Hashids\Facades\Hashids;
use function is_null;
use function strtolower;

/**
 * Class HashIdTrait.
 */
trait HashIdTrait
{
    /**
     * endpoint to be skipped from decoding their ID's (example for external ID's).
     *
     * @var array
     */
    private $skippedEndpoints = [
        //        'orders/{id}/external',
    ];

    /**
     * Hashes the value of a field (e.g., ID)
     * Will be used by the Eloquent Models (since it's used as trait there).
     *
     * @param string|null $field The field of the model to be hashed
     *
     * @return mixed
     */
    public function getHashedKey(?string $field = null)
    {
        if (!method_exists($this, 'getKeyName') || !method_exists($this, 'getAttribute')) {
            return null;
        }

        // if no key is set, use the default key name (i.e., id)
        if ($field === null) {
            $field = $this->getKeyName();
        }

        // hash the ID only if hash-id enabled in the config
        if (config('apiato.hash-id')) {
            // we need to get the VALUE for this KEY (model field)
            $value = $this->getAttribute($field);

            return $this->encoder($value);
        }

        return $this->getAttribute($field);
    }

    /**
     * without decoding the encoded ID's you won't be able to use
     * validation features like `exists:table,id`.
     *
     * @param array $requestData
     *
     * @return array
     */
    protected function decodeHashedIdsBeforeValidation(array $requestData)
    {

        // the hash ID feature must be enabled to use this decoder feature.
        if (config('apiato.hash-id') && isset($this->decode) && !empty($this->decode)) {
            // iterate over each key (ID that needs to be decoded) and call keys locator to decode them
            foreach ($this->decode as $key) {
                $requestData = $this->locateAndDecodeIds($requestData, $key);
            }
        }

        return $requestData;
    }

    /**
     * Search the IDs to be decoded in the request data.
     *
     * @param mixed  $requestData
     * @param string $key
     *
     * @return mixed
     */
    private function locateAndDecodeIds($requestData, $key)
    {
        // split the key based on the "."
        $fields = explode('.', $key);
        // loop through all elements of the key.
        return $this->processField($requestData, $fields);
    }

    /**
     * Recursive function to process (decode) the request data with a given key.
     *
     * @param mixed      $data
     * @param array|null $keysTodo
     *
     * @return array
     */
    private function processField($data, $keysTodo)
    {
        // check if there are no more fields to be processed
        if (empty($keysTodo)) {
            // there are no more keys left - so basically we need to decode this entry
            return $this->decode($data);
        }

        // take the first element from the field
        $field = array_shift($keysTodo);

        // is the current field an array?! we need to process it like crazy
        if ($field === '*') {
            //make sure field value is an array
            $data = is_array($data) ? $data : [$data];

            // process each field of the array (and go down one level!)
            $fields = $data;
            foreach ($fields as $key => $value) {
                $data[$key] = $this->processField($value, $keysTodo);
            }

            return $data;
        } else {
            // check if the key we are looking for does, in fact, really exist
            if (!array_key_exists($field, $data)) {
                return $data;
            }

            // go down one level
            $value        = $data[$field];
            $data[$field] = $this->processField($value, $keysTodo);

            return $data;
        }
    }

    /**
     * @param mixed    $subject
     * @param mixed    $findKey
     * @param \Closure $callback
     *
     * @return array
     */
    public function findKeyAndReturnValue(&$subject, $findKey, $callback)
    {
        // if the value is not an array, then you have reached the deepest point of the branch, so return the value.
        if (!is_array($subject)) {
            return $subject;
        }

        foreach ($subject as $key => $value) {
            if ($key === $findKey && isset($subject[$findKey])) {
                $subject[$key] = $callback($subject[$findKey]);
                break;
            }

            // add the value with the recursive call
            $this->findKeyAndReturnValue($value, $findKey, $callback);
        }
    }

    /**
     * @param array $ids
     *
     * @return array
     */
    public function decodeArray(array $ids)
    {
        $result = [];
        foreach ($ids as $id) {
            $result[] = $this->decode($id);
        }

        return $result;
    }

    /**
     * @param string|null $id
     * @param string|null $parameter
     *
     * @return array
     *
     * @throws IncorrectIdException
     */
    public function decode($id, $parameter = null)
    {
        // check if passed as null, (could be an optional decodable variable)
        if (is_null($id) || strtolower($id) === 'null') {
            return $id;
        }

        // check if is a number, to throw exception, since hashed ID should not be a number
        if (is_numeric($id)) {
            throw new IncorrectIdException('Only Hashed ID\'s allowed' . (!is_null($parameter) ? " ($parameter)." : '.'));
        }

        // do the decoding if the ID looks like a hashed one
        return empty($this->decoder($id)) ? [] : $this->decoder($id)[0];
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function encode($id)
    {
        return $this->encoder($id);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    private function decoder($id)
    {
        return Hashids::decode($id);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function encoder($id)
    {
        return Hashids::encode($id);
    }

    /**
     * Automatically decode any found `id` in the URL, no need to be used anymore.
     * Since now the user will define what needs to be decoded in the request.
     * All ID's passed with all endpoints will be decoded before entering the Application.
     */
    public function runHashedIdsDecoder(): void
    {
        if (config('apiato.hash-id')) {
            Route::bind('id', function (string $id, Router $route) {
                // skip decoding some endpoints
                if (!in_array($route->uri(), $this->skippedEndpoints)) {

                    // decode the ID in the URL
                    $decoded = $this->decoder($id);

                    if (empty($decoded)) {
                        throw new IncorrectIdException('ID (' . $id . ') is incorrect, consider using the hashed ID
                        instead of the numeric ID.');
                    }

                    return $decoded[0];
                }
            });
        }
    }
}
