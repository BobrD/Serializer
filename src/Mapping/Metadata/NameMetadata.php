<?php

namespace BobrD\Serializer\Mapping\Metadata;

class NameMetadata implements MetadataInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->name = unserialize($serialized);
    }
}
