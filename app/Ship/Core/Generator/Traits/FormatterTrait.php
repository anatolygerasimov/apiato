<?php

namespace App\Ship\Core\Generator\Traits;

trait FormatterTrait
{
    /**
     * @param $word
     *
     * @return  string
     */
    public function capitalize($word)
    {
        return ucfirst($word);
    }

    /**
     * @param $string
     *
     * @return  string
     */
    protected function trimString($string)
    {
        return trim($string);
    }
}
