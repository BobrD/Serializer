<?php

namespace BobrD\Serializer\Mapping\Metadata;

class PropertyMetadata implements MetadataInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var TypeMetadata
     */
    private $type;

    /**
     * @var \ReflectionProperty
     */
    private $reflection;

    /**
     * @var MetadataInterface[]
     */
    private $metadatas = [];

    /**
     * @param TypeMetadata        $type
     * @param \ReflectionProperty $reflection
     */
    public function __construct(TypeMetadata $type, \ReflectionProperty $reflection)
    {
        $this->name = $reflection->getName();
        $this->type = $type;
        $this->reflection = $reflection;
    }

    /**
     * @param MetadataInterface[] $metadatas
     */
    public function setMetadatas(array $metadatas)
    {
        foreach ($metadatas as $metadata) {
            $this->addMetadata($metadata);
        }
    }

    /**
     * @param MetadataInterface $metadata
     */
    public function addMetadata(MetadataInterface $metadata)
    {
        $this->metadatas[get_class($metadata)] = $metadata;
    }

    /**
     * @return MetadataInterface[]
     */
    public function getMetadatas()
    {
        return $this->metadatas;
    }

    /**
     * @param string $name
     * 
     * @return MetadataInterface|null
     */
    public function getMetadata($name)
    {
        return isset($this->metadatas[$name])
            ? $this->metadatas[$name]
            : null;
    }

    /** 
     * @return \ReflectionProperty
     */
    public function getReflection()
    {
        return $this->reflection;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return TypeMetadata
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            $this->name,
            $this->type,
            $this->reflection->getName(),
            $this->metadatas,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list(
            $this->name,
            $this->type,
            $class,
            $this->metadatas
        ) = unserialize($serialized);

        $this->reflection = new \ReflectionClass($class);
    }
}
