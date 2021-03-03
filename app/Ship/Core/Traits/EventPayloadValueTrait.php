<?php

declare(strict_types=1);

namespace App\Ship\Core\Traits;

use LogicException;
use function get_class;

trait EventPayloadValueTrait
{
    public function __isset(string $name): bool
    {
        try {
            $value = $this->{$name};
        } catch (LogicException $e) {
            return false;
        }

        return isset($value);
    }

    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new LogicException(sprintf('Cannot get non existing property %s->%s.', get_class($this), $name));
        }

        return $this->{$name};
    }
}
