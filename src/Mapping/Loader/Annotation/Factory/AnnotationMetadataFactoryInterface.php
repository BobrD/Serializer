<?php

namespace BobrD\Serializer\Mapping\Loader\Annotation\Factory;

use BobrD\Serializer\Annotation\SerializerAnnotationInterface;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;

interface AnnotationMetadataFactoryInterface
{
    /**
     * @param SerializerAnnotationInterface $annotation
     *
     * @return MetadataInterface
     */
    public function createMetadata(SerializerAnnotationInterface $annotation);

    /**
     * @param SerializerAnnotationInterface $annotation
     * 
     * @return bool
     */
    public function supportAnnotation(SerializerAnnotationInterface $annotation);
}
