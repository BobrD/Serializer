<?php

namespace BobrD\Serializer;

use BobrD\Serializer\Exception\HydratorException;
use BobrD\Serializer\ExcludeVoter\GroupExcludeVoter;
use BobrD\Serializer\Hydrator\ClassHydrator;
use BobrD\Serializer\Hydrator\CollectionHydrator;
use BobrD\Serializer\Hydrator\TypeHydrator;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;
use BobrD\Serializer\Mapping\Metadata\TypeMetadata;

class Hydrator implements HydratorInterface
{
    /**
     * @var HydratorInterface[]
     */
    private $hydrators = [];

    public function __construct()
    {
        $defaultHydrators = [
            $classHydrator = new ClassHydrator(),
            new TypeHydrator(),
            new CollectionHydrator(),
        ];

        $classHydrator->addExcludeVoter(new GroupExcludeVoter());

        foreach ($defaultHydrators as $defaultHydrator) {
            $this->addHydrator($defaultHydrator);
        }
    }

    /**
     * @param HydratorInterface $hydrator
     */
    public function addHydrator(HydratorInterface $hydrator)
    {
        if ($hydrator instanceof HydratorAwareInterface) {
            $hydrator->setHydrator($this);
        }

        $this->hydrators[] = $hydrator;
    }

    /**
     * @param mixed $data
     * @param TypeMetadata $metadata
     * @param array $context
     * 
     * @return array
     * 
     * @throws HydratorException
     */
    public function hydrate($data, TypeMetadata $metadata, array $context = [])
    {
        foreach ($this->hydrators as $hydrator) {
            if ($hydrator->supportMetadata($metadata)) {
                return $hydrator->hydrate($data, $metadata, $context);
            }
        }

        throw HydratorException::unsupportedMetadata($metadata);
    }

    /**
     * {@inheritdoc}
     */
    public function supportMetadata(MetadataInterface $metadata)
    {
        foreach ($this->hydrators as $hydrator) {
            if ($hydrator->supportMetadata($metadata)) {
                return true;
            }
        }

        return false;
    }
}
