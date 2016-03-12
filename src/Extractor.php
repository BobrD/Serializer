<?php

namespace BobrD\Serializer;

use BobrD\Serializer\Exception\ExtractorException;
use BobrD\Serializer\Extractor\ClassExtractor;
use BobrD\Serializer\Extractor\CollectionExtractor;
use BobrD\Serializer\Extractor\TypeExtractor;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;

class Extractor implements ExtractorInterface
{
    /**
     * @var ExtractorInterface[]
     */
    private $extractors = [];

    public function __construct()
    {
        $defaultExtractors = [
            new TypeExtractor(),
            new CollectionExtractor(),
            new ClassExtractor(),
        ];

        foreach ($defaultExtractors as $extractor) {
            $this->addExtractor($extractor);
        }
    }

    /**
     * @param ExtractorInterface $extractor
     */
    public function addExtractor(ExtractorInterface $extractor)
    {
        if ($extractor instanceof ExtractorAwareInterface) {
            $extractor->setExtractor($this);
        }

        $this->extractors[] = $extractor;
    }

    /**
     * @param mixed $data
     * @param MetadataInterface $metadata
     * @param array $context
     * 
     * @return array
     * 
     * @throws ExtractorException
     */
    public function extract($data, MetadataInterface $metadata, array $context = [])
    {
        foreach ($this->extractors as $extractor) {
            if ($extractor->supportMetadata($metadata)) {
                return $extractor->extract($data, $metadata, $context);
            }
        }

        throw ExtractorException::unsupportedMetadata($metadata);
    }

    /**
     * {@inheritdoc}
     */
    public function supportMetadata(MetadataInterface $metadata)
    {
        foreach ($this->extractors as $extractor) {
            if ($extractor->supportMetadata($metadata)) {
               return true;
            }
        }

        return false;
    }
}
