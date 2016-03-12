<?php

namespace BobrD\Serializer\Mapping\Loader\Annotation;

use BobrD\Serializer\Annotation\SerializerAnnotationInterface;
use BobrD\Serializer\Exception\MetadataException;
use BobrD\Serializer\Mapping\Loader\Annotation\Factory\AnnotationMetadataFactoryInterface;
use BobrD\Serializer\Mapping\Loader\Annotation\Factory\CollectionMetadataFactory;
use BobrD\Serializer\Mapping\Loader\Annotation\Factory\GroupMetadataFactory;
use BobrD\Serializer\Mapping\Loader\Annotation\Factory\NameMetadataFactory;
use BobrD\Serializer\Mapping\Loader\Annotation\Factory\TypeMetadataFactory;
use BobrD\Serializer\Mapping\Loader\MetadataLoaderInterface;
use BobrD\Serializer\Mapping\Metadata\ClassMetaData;
use BobrD\Serializer\Mapping\Metadata\MetadataInterface;
use BobrD\Serializer\Mapping\Metadata\PropertyMetadata;
use BobrD\Serializer\Mapping\Metadata\TypeMetadata;
use Doctrine\Common\Annotations\Reader;

class AnnotationLoader implements MetadataLoaderInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var AnnotationMetadataFactoryInterface[]
     */
    private $metadataFactories = [];

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;

        $defaultMetadataFactories = [
            new GroupMetadataFactory(),
            new NameMetadataFactory(),
            new CollectionMetadataFactory(),
            new TypeMetadataFactory(),
        ];

        foreach ($defaultMetadataFactories as $defaultMetadataFactory) {
            $this->addMetadataFactory($defaultMetadataFactory);
        }
    }

    /**
     * @param AnnotationMetadataFactoryInterface $annotationMetadataFactory
     */
    public function addMetadataFactory(AnnotationMetadataFactoryInterface $annotationMetadataFactory)
    {
        if ($annotationMetadataFactory instanceof AnnotationLoaderAwareInterface) {
            $annotationMetadataFactory->setAnnotationLoader($this);
        }

        $this->metadataFactories[] = $annotationMetadataFactory;
    }

    /**
     * @param string $type
     * 
     * @return ClassMetaData
     * 
     * @throws MetadataException
     */
    public function loadMetadata($type)
    {
        $reflectionClass = new \ReflectionClass($type);

        $classMetadata = new ClassMetaData($reflectionClass);

        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            $metadatas = [];
            $typeMetadata = null;
            foreach ($this->reader->getPropertyAnnotations($reflectionProperty) as $propertyAnnotation) {
                if (!$propertyAnnotation instanceof SerializerAnnotationInterface) {
                    continue;
                }

                $metadata = $this->createMetadata($propertyAnnotation);

                if ($metadata instanceof TypeMetadata) {
                    $typeMetadata = $metadata;
                    continue;
                }

                $metadatas[] = $metadata;
            };

            if (null === $typeMetadata) {
                throw MetadataException::missingTypeAnnotation($reflectionClass->getName(), $reflectionProperty->getName());
            }
            
            $propertyMetadata = new PropertyMetadata($typeMetadata, $reflectionProperty);

            $propertyMetadata->setMetadatas($metadatas);

            $classMetadata->addProperty($propertyMetadata);
        }

        return $classMetadata;
    }

    /**
     * @param SerializerAnnotationInterface $annotation
     *
     * @return MetadataInterface
     */
    private function createMetadata(SerializerAnnotationInterface $annotation)
    {
        foreach ($this->metadataFactories as $metadataFactory) {
            if ($metadataFactory->supportAnnotation($annotation)) {
                return $metadataFactory->createMetadata($annotation);
            }
        }

        throw new \LogicException();
    }
}
