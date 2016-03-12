<?php

namespace BobrD\Serializer\Exception;

use BobrD\Serializer\Annotation\SerializerAnnotationInterface;

class MetadataException extends \Exception implements SerializerExceptionInterface
{
    /**
     * @param SerializerAnnotationInterface $annotation
     * 
     * @return static
     */
    public static function unsupportedAnnotation(SerializerAnnotationInterface $annotation)
    {
        return new static(sprintf('There are no factory for class annotation "%s".', get_class($annotation)));
    }

    /**
     * @param string $class
     * @param string $property
     * 
     * @return static
     */
    public static function missingTypeAnnotation($class, $property)
    {
        return new static(sprintf('Missing type annotation on %s::%s', $class, $property));
    }
}
