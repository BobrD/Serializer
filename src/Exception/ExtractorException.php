<?php

namespace BobrD\Serializer\Exception;

use BobrD\Serializer\Mapping\Metadata\MetadataInterface;

class ExtractorException extends \Exception implements SerializerExceptionInterface
{
    /**
     * @param MetadataInterface $metadata
     * 
     * @return static
     */
    public static function unsupportedMetadata(MetadataInterface $metadata)
    {
        return new static(sprintf('There are no extractor for class metadata "%s".', get_class($metadata)));
    }
}
