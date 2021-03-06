<?php

declare(strict_types=1);

namespace Smile\GdprDump\Config;

class Config implements ConfigInterface
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->items = $data;
    }

    /**
     * @inheritdoc
     */
    public function get(string $key, $default = null)
    {
        return $this->has($key) ? $this->items[$key] : $default;
    }

    /**
     * @inheritdoc
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @inheritdoc
     */
    public function set(string $key, $value): ConfigInterface
    {
        $this->items[$key] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @inheritdoc
     */
    public function merge(array $data): ConfigInterface
    {
        $this->items = $this->mergeArray($this->items, $data);

        return $this;
    }

    /**
     * Merge two arrays.
     *
     * @param array $data
     * @param array $override
     * @return array
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    private function mergeArray(array $data, array $override): array
    {
        foreach ($override as $key => $value) {
            if (array_key_exists($key, $data)) {
                if (is_array($value) && is_array($data[$key])) {
                    // Merge values
                    $data[$key] = $this->mergeArray($data[$key], $value);
                } else {
                    // Overwrite value
                    $data[$key] = $value;
                }
            } else {
                // Value not present in result array, append it
                $data[$key] = $value;
            }
        }

        return $data;
    }
}
