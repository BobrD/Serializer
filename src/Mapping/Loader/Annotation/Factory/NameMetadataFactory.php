<?php

namespace BobrD\Serializer\Mapping\Loader\Annotation\Factory;

use BobrD\Serializer\Annotation\Name;
use BobrD\Serializer\Annotation\SerializerAnnotationInterface;
use BobrD\Serializer\Mapping\Metadata\NameMetadata;

class NameMetadataFactory implements AnnotationMetadataFactoryInterface
{
    /**
     * @param SerializerAnnotationInterface|Name $annotation
     * 
     * @return NameMetadata
     */
    public function createMetadata(SerializerAnnotationInterface $annotation)
    {
        return new NameMetadata($annotation->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function supportAnnotation(SerializerAnnotationInterface $annotation)
    {
        return get_class($annotation) === Name::class;
    }
}
