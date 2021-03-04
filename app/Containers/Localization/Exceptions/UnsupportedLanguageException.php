<?php

namespace App\Containers\Localization\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class UnsupportedLanguageException.
 */
class UnsupportedLanguageException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_PRECONDITION_FAILED;

    /**
     * @var string
     */
    public $message = 'Unsupported Language.';
}
