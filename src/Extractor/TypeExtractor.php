<?php

namespace BobrD\Serializer\Extractor;

use BobrD\Serializer\ExtractorInterface;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;
use BobrD\Serializer\Mapping\Metadata\TypeMetadata;

class TypeExtractor implements ExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function extract($data, MetadataInterface $metadata, array $context = [])
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
