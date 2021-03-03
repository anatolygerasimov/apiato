<?php

namespace App\Ship\Core\Abstracts\Controllers;

/**
 * Class WebController.
 */
abstract class WebController extends Controller
{
    /**
     * The type of this controller. This will be accessible mirrored in the Actions.
     * Giving each Action the ability to modify it's internal business logic based on the UI type that called it.
     *
     * @var  string
     */
    public $ui = 'web';
}
