<?php

namespace BobrD\Serializer\Mapping\Metadata;

class ClassMetaData extends TypeMetadata
{
    /**
     * @var PropertyMetadata[]
     */
    private $properties = [];

    /**
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * @param \ReflectionClass $reflectionClass
     */
    public function __construct(\ReflectionClass $reflectionClass)
    {
        parent::__construct($reflectionClass->getName());

        $this->reflection = $reflectionClass;
    }

    /**
     * @param PropertyMetadata $propertyMetadata
     */
    public function addProperty(PropertyMetadata $propertyMetadata)
    {
        $this->properties[] = $propertyMetadata;
    }

    /** 
     * @return PropertyMetadata[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /** 
     * @return \ReflectionClass
     */
    public function getReflection()
    {
        return $this->reflection;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            $this->reflection->getName(),
            $this->properties,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($class, $this->properties) = unserialize($serialized);

        $this->reflection = new \ReflectionClass($class);
    }
}
