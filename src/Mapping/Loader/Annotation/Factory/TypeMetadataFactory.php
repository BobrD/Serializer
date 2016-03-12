<?php

namespace BobrD\Serializer\Mapping\Loader\Annotation\Factory;

use BobrD\Serializer\Annotation\SerializerAnnotationInterface;
use BobrD\Serializer\Annotation\Type;
use BobrD\Serializer\Mapping\Loader\Annotation\AnnotationLoaderAwareInterface;
use BobrD\Serializer\Mapping\Loader\Annotation\AnnotationLoaderAwareTrait;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;
use BobrD\Serializer\Mapping\Metadata\TypeMetadata;

class TypeMetadataFactory implements AnnotationMetadataFactoryInterface, AnnotationLoaderAwareInterface
{
    use AnnotationLoaderAwareTrait;

    /**
     * @param SerializerAnnotationInterface|Type $annotation
     * 
     * @return MetadataInterface
     */
    public function createMetadata(SerializerAnnotationInterface $annotation)
    {
        $type = $annotation->getType();

        if (class_exists($type)) {
            return $this->annotationLoader->loadMetadata($type);
        }

        return new TypeMetadata($type);
    }

    /**
     * {@inheritdoc}
     */
    public function supportAnnotation(SerializerAnnotationInterface $annotation)
    {
        return get_class($annotation) === Type::class;
    }
}
