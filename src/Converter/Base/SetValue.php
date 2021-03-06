<?php

declare(strict_types=1);

namespace Smile\GdprDump\Converter\Base;

use InvalidArgumentException;
use Smile\GdprDump\Converter\ConverterInterface;

class SetValue implements ConverterInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param array $parameters
     * @throws InvalidArgumentException
     */
    public function __construct(array $parameters)
    {
        if (!array_key_exists('value', $parameters)) {
            throw new InvalidArgumentException('The parameter "value" is required.');
        }

        $this->value = $parameters['value'];
    }

    /**
     * @inheritdoc
     */
    public function convert($value, array $context = [])
    {
        return $this->value;
    }
}
