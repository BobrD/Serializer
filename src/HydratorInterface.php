<?php

namespace BobrD\Serializer;

use BobrD\Serializer\Mapping\Metadata\MetadataInterface;
use BobrD\Serializer\Mapping\Metadata\TypeMetadata;

interface HydratorInterface
{
    /**
     * @param mixed $data
     * @param TypeMetadata $metadata
     * @param array $context
     * 
     * @return array
     */
    public function hydrate($data, TypeMetadata $metadata, array $context = []);

    /**
     * @param MetadataInterface $metadata
     *
     * @return bool
     */
    public function supportMetadata(MetadataInterface $metadata);
}
