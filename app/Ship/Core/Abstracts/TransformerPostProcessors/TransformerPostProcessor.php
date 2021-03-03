<?php

declare(strict_types=1);

namespace App\Ship\Core\Abstracts\TransformerPostProcessors;

use App\Ship\Core\Abstracts\Transporters\Transporter;

/**
 * Class TransformerPostProcessor
 */
abstract class TransformerPostProcessor
{
    /**
     * @var Transporter
     */
    protected Transporter $transporter;

    /**
     * @param array $transformedData  Data with applyed Transformers
     *
     * @return array
     */
    abstract public function postProcess(array $transformedData): array;

    /**
     * Store parameter for postProcess method
     *
     * @param Transporter $parameter
     *
     * @return $this
     */
    public function withTransport(Transporter $parameter)
    {
        $this->transporter = $parameter;
        return $this;
    }
}
