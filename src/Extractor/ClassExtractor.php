<?php

namespace BobrD\Serializer\Extractor;

use BobrD\Serializer\ExcludeVoter\ExcludeVoterInterface;
use BobrD\Serializer\ExtractorAwareInterface;
use BobrD\Serializer\ExtractorAwareTrait;
use BobrD\Serializer\ExtractorInterface;
use BobrD\Serializer\Mapping\Metadata\ClassMetaData;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;
use BobrD\Serializer\Mapping\Metadata\NameMetadata;
use BobrD\Serializer\Mapping\Metadata\PropertyMetadata;

class ClassExtractor implements ExtractorInterface, ExtractorAwareInterface
{
    use ExtractorAwareTrait;

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
     * @param mixed                           $data
     * @param MetadataInterface|ClassMetaData $metadata
     * @param array                           $context
     *
     * @return array
     */
    public function extract($data, MetadataInterface $metadata, array $context = [])
    {
        $extracted = [];
        foreach ($metadata->getProperties() as $propertyMetadata) {
            if ($this->exclude($propertyMetadata, $context)) {
                continue;
            }

            $reflectionProperty = $propertyMetadata->getReflection();

            $reflectionProperty->setAccessible(true);

            $value = $reflectionProperty->getValue($data);

            $extracted[$this->getName($propertyMetadata)] = $this->extractor->extract($value, $propertyMetadata->getType(), $context);
        }

        return $extracted;
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
}
