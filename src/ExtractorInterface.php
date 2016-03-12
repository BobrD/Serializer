<?php

namespace BobrD\Serializer;

use BobrD\Serializer\Mapping\Metadata\MetadataInterface;

interface ExtractorInterface
{
    /**
     * @param mixed             $data
     * @param MetadataInterface $metadata
     * @param array             $context
     *
     * @return mixed
     */
    public function extract($data, MetadataInterface $metadata, array $context = []);

    /**
     * @param MetadataInterface $metadata
     * 
     * @return bool
     */
    public function supportMetadata(MetadataInterface $metadata);
}
