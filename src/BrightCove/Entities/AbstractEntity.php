<?php

namespace ContemporaryVA\BrightCove\Entities;

use ContemporaryVA\BrightCove\Exceptions\InvalidArgumentException;
use Illuminate\Support\Collection;

class AbstractEntity
{

    /**
     * @var array
     */
    protected $unknownProperties = [];

    /**
     * @param \stdClass|array $parameters
     */
    public function __construct($parameters)
    {
        $this->build($parameters);
    }

    /**
     * @param string $property
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function __get($property)
    {
        if (!property_exists($this, $property)) {
            if (array_key_exists($property, $this->unknownProperties)) {
                return $this->unknownProperties[$property];
            }
            throw new InvalidArgumentException(sprintf(
                'Property "%s::%s" does not exist.', get_class($this), $property
            ));
        }
    }

    /**
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {

        if (!property_exists($this, $property)) {
            $this->unknownProperties[$property] = $value;
        }
    }

    /**
     * @return array
     */
    public function getUnknownProperties()
    {
        return $this->unknownProperties;
    }

    /**
     * @param \stdClass|array $parameters
     */
    public function build($parameters)
    {
        foreach ($parameters as $property => $value) {
            $property = camel_case($property);
            $this->$property = $value;
        }
    }

    public function buildParameterEntity($property, $class)
    {
        if (property_exists($this, $property) && !empty($this->$property)) {
            $this->$property = new $class($this->$property);
        }
    }

    public function buildParameterEntityCollection($property, $class)
    {
        if (property_exists($this, $property) && count($this->$property)) {
            $collection = new Collection();
            foreach ($this->$property as $parameters) {
                $entity = new $class($parameters);
                $collection->push($entity);
            }
            $this->$property = $collection;
        }
    }

}