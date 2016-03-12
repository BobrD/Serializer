<?php

namespace BobrD\Serializer\Hydrator;

use BobrD\Serializer\HydratorAwareInterface;
use BobrD\Serializer\HydratorAwareTrait;
use BobrD\Serializer\HydratorInterface;
use BobrD\Serializer\Mapping\Metadata\CollectionMetadata;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;
use BobrD\Serializer\Mapping\Metadata\TypeMetadata;

class CollectionHydrator implements HydratorInterface, HydratorAwareInterface
{
    use HydratorAwareTrait;

    /**
     * @param array                           $data
     * @param CollectionMetadata|TypeMetadata $metadata
     * @param array                           $context
     * 
     * @return array
     */
    public function hydrate($data, TypeMetadata $metadata, array $context = [])
    {
        return array_map(function ($item) use ($metadata, $context) {
            return $this->hydrator->hydrate($item, $metadata->getItemType(), $context);
        }, $data);
    }

    public function supportMetadata(MetadataInterface $metadata)
    {
        return get_class($metadata) === CollectionMetadata::class;
    }
}
