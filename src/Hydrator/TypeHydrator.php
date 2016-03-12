<?php

namespace BobrD\Serializer\Hydrator;

use BobrD\Serializer\HydratorInterface;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;
use BobrD\Serializer\Mapping\Metadata\TypeMetadata;

class TypeHydrator implements HydratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function hydrate($data, TypeMetadata $metadata, array $context = [])
    {
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportMetadata(MetadataInterface $metadata)
    {
        return get_class($metadata) === TypeMetadata::class;
    }
}
