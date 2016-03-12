<?php

namespace BobrD\Serializer\Mapping\Loader\Annotation\Factory;

use BobrD\Serializer\Annotation\Collection;
use BobrD\Serializer\Annotation\SerializerAnnotationInterface;
use BobrD\Serializer\Mapping\Loader\Annotation\AnnotationLoaderAwareInterface;
use BobrD\Serializer\Mapping\Loader\Annotation\AnnotationLoaderAwareTrait;
use BobrD\Serializer\Mapping\Metadata\CollectionMetadata;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;

class CollectionMetadataFactory implements AnnotationMetadataFactoryInterface, AnnotationLoaderAwareInterface
{
    use AnnotationLoaderAwareTrait;

    /**
     * @param SerializerAnnotationInterface|Collection $annotation
     * 
     * @return CollectionMetadata|MetadataInterface
     */
    public function createMetadata(SerializerAnnotationInterface $annotation)
    {
        return new CollectionMetadata($this->annotationLoader->loadMetadata($annotation->getType()));
    }

    /**
     * {@inheritdoc}
     */
    public function supportAnnotation(SerializerAnnotationInterface $annotation)
    {
        return get_class($annotation) === Collection::class;
    }
}
