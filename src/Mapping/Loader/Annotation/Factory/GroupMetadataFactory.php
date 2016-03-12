<?php

namespace BobrD\Serializer\Mapping\Loader\Annotation\Factory;

use BobrD\Serializer\Annotation\Group;
use BobrD\Serializer\Annotation\SerializerAnnotationInterface;
use BobrD\Serializer\Mapping\Metadata\GroupMetadata;

class GroupMetadataFactory implements AnnotationMetadataFactoryInterface
{
    /**
     * @param SerializerAnnotationInterface|Group $annotation
     * 
     * @return GroupMetadata
     */
    public function createMetadata(SerializerAnnotationInterface $annotation)
    {
        return new GroupMetadata($annotation->getGroups());
    }

    /**
     * {@inheritdoc}
     */
    public function supportAnnotation(SerializerAnnotationInterface $annotation)
    {
        return get_class($annotation) === Group::class;
    }
}
