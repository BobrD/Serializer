<?php

namespace BobrD\Serializer\Extractor;

use BobrD\Serializer\ExtractorAwareInterface;
use BobrD\Serializer\ExtractorAwareTrait;
use BobrD\Serializer\ExtractorInterface;
use BobrD\Serializer\Mapping\Metadata\CollectionMetadata;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;

class CollectionExtractor implements ExtractorInterface, ExtractorAwareInterface
{
    use ExtractorAwareTrait;

    /**
     * @param mixed                                $data
     * @param MetadataInterface|CollectionMetadata $metadata
     * @param array                                $context
     * 
     * @return array
     */
    public function extract($data, MetadataInterface $metadata, array $context = [])
    {
        return array_map(function ($item) use ($metadata, $context) {
            return $this->extractor->extract($item, $metadata->getItemType(), $context);
        }, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportMetadata(MetadataInterface $metadata)
    {
        return get_class($metadata) === CollectionMetadata::class;
    }
}
