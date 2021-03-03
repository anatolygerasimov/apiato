<?php

namespace App\Ship\Core\Exceptions;

use App\Ship\Core\Abstracts\TransformerPostProcessors\TransformerPostProcessor;
use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class InvalidTransformerPostProcessorException.
 *
 */
class InvalidTransformerPostProcessorException extends Exception
{
    public $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'TransformerPostProcessors must extended the ' . TransformerPostProcessor::class . ' class.';
}
