<?php

namespace Creatuity\Interception\Generator;

use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class NoSerialize
 */
class NoSerialize implements SerializerInterface
{
    /**
     * Serialize data into string
     *
     * @param string|int|float|bool|array|null $data
     * @return string|bool
     * @throws \InvalidArgumentException
     * @since 101.0.0
     */
    public function serialize($data)
    {
        return $data;
    }

    /**
     * Unserialize the given string
     *
     * @param string $string
     * @return string|int|float|bool|array|null
     * @throws \InvalidArgumentException
     * @since 101.0.0
     */
    public function unserialize($string)
    {
        return $string;
    }
}
