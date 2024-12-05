<?php

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @template TKey of array-key
 * @template TValue
 * @implements Arrayable<TKey, TValue>
 * @codeCoverageIgnore
 */
// @CodeCoverageIgnoreStart
abstract class AbstractDTO implements Arrayable, JsonSerializable
{
    /**
     * @return array<TKey, TValue>
     */
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

    /**
     * Convert the DTO to JSON.
     *
     * @param int $options
     * @return string
     * @throws \RuntimeException if JSON encoding fails
     */
    public function toJson(int $options = 0): string
    {
        $json = json_encode($this->toArray(), $options);

        if ($json === false) {
            throw new \RuntimeException('Failed to encode JSON: ' . json_last_error_msg());
        }

        return $json;
    }

    /**
     * Prepare the object for JSON serialization.
     *
     * @return array<TKey, TValue>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
// @CodeCoverageIgnoreEnd