<?php

namespace BestBrands\KiyohClient\Models;

use DateTime;
use InvalidArgumentException;

/**
 * Class AModel
 * @package BestBrands\KiyohClient\Models
 */
class AModel
{
    /**
     * Handle the calling of functions
     *
     * @param string $method
     * @param array $args
     *
     * @return mixed
     */
    public function __call(string $method, array $args)
    {
        $get = $this->_startsWith($method, 'get');
        $set = $this->_startsWith($method, 'set');

        if ($get || $set) {
            $variable = lcfirst(substr($method, 3));
            if (!$this->_propertyExists($variable))
                throw new \BadMethodCallException(sprintf("Invalid variable name `%s`", $variable));

            if (count($args) !== (int)$set)
                throw new \BadMethodCallException("Invalid parameters");
            else if ($set) {
                $this->{$variable} = reset($args);
                return $this;
            } else {
                return $this->{$variable};
            }
        }

        throw new \BadMethodCallException();
    }

    /**
     * Check whether a property exists, if not, throw an error
     *
     * @param string $property
     *
     * @return bool
     */
    protected function _propertyExists(string $property): bool
    {
        return isset($this->{$property});
    }

    /**
     * Check whether the string starts with another string
     *
     * @param string $target
     * @param string $starts_with
     *
     * @return bool
     */
    protected function _startsWith(string $target, string $starts_with)
    {
        return (substr($target, 0, strlen($starts_with)) === $starts_with);
    }

    /**
     * Parse the date
     *
     * @param $updatedSince
     *
     * @return DateTime
     */
    protected function _parseDate($updatedSince): \DateTime
    {
        $result = new DateTime();

        if ($updatedSince instanceof \DateTime)
            $result = $updatedSince;
        elseif (gettype($updatedSince) === 'int')
            ($result = new \DateTime())->setTimestamp($updatedSince);
        elseif ($parsed = \DateTime::createFromFormat("Y-m-d\TH:i:s.v\Z", $updatedSince))
            $result = $parsed;

        return $result;
    }

    /**
     * Check if array is pure of type $type
     *
     * @param array  $array
     * @param string $type
     *
     * @throws InvalidArgumentException
     */
    protected function _checkIfPureArray(array $array, string $type): void {
        array_walk($array, function ($item) use ($type) {
            if (!is_a($item, $type)) {
                throw new InvalidArgumentException(sprintf("Unexpected class %s", get_class($item)));
            }
        });
    }

    /**
     * Export the current object to an array
     */
    public function __toArray()
    {
        $result = [];

        foreach (get_object_vars($this) as $var => $value) {
            try {
                $value = $this->{'get' . ucfirst($var)}();

                if (is_array($value)) {
                    $result[$var] = array_map(fn(AModel $model) => $model->__toArray(), $value);
                } elseif ($value instanceof AModel) {
                    $result[$var] = $value->__toArray();
                } else {
                    $result[$var] = $value;
                }
            } catch (\BadMethodCallException $e) {
            }
        }

        return $result;
    }
}