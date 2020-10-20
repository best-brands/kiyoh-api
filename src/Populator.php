<?php

namespace BestBrands\KiyohClient;

/**
 * Class Populator
 * @package HarmSmits\BolComClient
 */
class Populator
{
    const TYPE_ARRAY_OF_OBJECTS = 'OBJ_ARRAY';
    const TYPE_OBJECT = 'OBJ';

    /**
     * Populate the specification with the retrieved data
     *
     * @param array $spec
     * @param array $rawData
     *
     * @return mixed
     */
    public function populate(array $spec, array $rawData)
    {
        if ($spec['$type'] == self::TYPE_ARRAY_OF_OBJECTS) {
            return ($this->populateArrayOfObjects($spec, $rawData, $spec['$ref']));
        } else {
            return ($this->populateObject($spec, $rawData, $spec['$ref']));
        }
    }

    /**
     * Populate an array of objects according to the specification.
     *
     * @param $spec
     * @param array $rawData
     * @param string $class
     *
     * @return array
     */
    private function populateArrayOfObjects($spec, array $rawData, string $class): array
    {
        $data = [];
        foreach ($rawData as $rawDataItem) {
            $data[] = $this->populateObject($spec, $rawDataItem, $class);
        }
        return ($data);
    }

    /**
     * Map a single object to its properties
     *
     * @param $spec
     * @param array $rawData
     * @param string $class
     *
     * @return mixed
     */
    public function populateObject($spec, array $rawData, string $class)
    {
        $instance = new $class;

        foreach ($rawData as $key => $value) {
            if (isset($spec[$key]))
                $value = $this->populate($spec[$key], $rawData[$key]);

            try {
                $instance->{'set' . ucfirst($key)}($value);
            } catch (\BadMethodCallException $exception) {
            }
        }

        return ($instance);
    }
}