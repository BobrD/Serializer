<?php

namespace BobrD\Serializer\Hydrator;

use BobrD\Serializer\ExcludeVoter\ExcludeVoterInterface;
use BobrD\Serializer\HydratorAwareInterface;
use BobrD\Serializer\HydratorAwareTrait;
use BobrD\Serializer\HydratorInterface;
use BobrD\Serializer\Mapping\Metadata\ClassMetaData;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;
use BobrD\Serializer\Mapping\Metadata\NameMetadata;
use BobrD\Serializer\Mapping\Metadata\PropertyMetadata;
use BobrD\Serializer\Mapping\Metadata\TypeMetadata;

class ClassHydrator implements HydratorInterface, HydratorAwareInterface
{
    use HydratorAwareTrait;

    /**
     * @var ExcludeVoterInterface[]
     */
    private $excludeVoters = [];

    /**
     * @param ExcludeVoterInterface $voter
     */
    public function addExcludeVoter(ExcludeVoterInterface $voter)
    {
        $this->excludeVoters[] = $voter;
    }

    /**
     * @param array                      $data
     * @param TypeMetadata|ClassMetaData $metadata
     * @param array                      $context
     * 
     * @return object
     */
    public function hydrate($data, TypeMetadata $metadata, array $context = [])
    {
        $object = $this->createObject($metadata->getType());

        foreach ($metadata->getProperties() as $propertyMetadata) {
            if ($this->exclude($propertyMetadata, $context)) {
                continue;
            }

            $reflectionProperty = $propertyMetadata->getReflection();
            $reflectionProperty->setAccessible(true);

            $name = $this->getName($propertyMetadata);

            if (!isset($data[$name])) {
                continue;
            }

            $reflectionProperty->setValue(
                $object,
                $this->hydrator->hydrate(
                    $data[$this->getName($propertyMetadata)],
                    $propertyMetadata->getType()
                )
            );
        }

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function supportMetadata(MetadataInterface $metadata)
    {
        return get_class($metadata) === ClassMetaData::class;
    }

    /**
     * @param PropertyMetadata $propertyMetadata
     * 
     * @return string
     */
    private function getName(PropertyMetadata $propertyMetadata)
    {
        $nameMetadata = $propertyMetadata->getMetadata(NameMetadata::class);
        if (!$nameMetadata instanceof NameMetadata) {
            return $propertyMetadata->getName();
        }

        return $nameMetadata->getName();
    }

    /**
     * @param PropertyMetadata $propertyMetadata
     * @param array            $context
     * 
     * @return bool
     */
    private function exclude(PropertyMetadata $propertyMetadata, array $context)
    {
        foreach ($this->excludeVoters as $excludeVoter) {
            if ($excludeVoter->vote($propertyMetadata, $context)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $class
     * 
     * @return object
     */
    private function createObject($class)
    {
        return (new \ReflectionClass($class))->newInstanceWithoutConstructor();
    }
}
