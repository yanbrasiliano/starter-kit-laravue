<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

abstract class AbstractDTO implements Arrayable, JsonSerializable
{
    public function toArray(): array
    {
        $recursiveConversion = function ($item) use (&$recursiveConversion) {
            if (is_object($item)) {
                $item = get_object_vars($item);
            }

            if (is_array($item)) {
                return array_map($recursiveConversion, $item);
            }

            return $item;
        };

        return $recursiveConversion($this);
    }

    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
