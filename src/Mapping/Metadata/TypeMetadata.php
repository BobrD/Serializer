<?php

namespace BobrD\Serializer\Mapping\Metadata;

class TypeMetadata implements MetadataInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
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
        return serialize($this->type);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->type = unserialize($serialized);
    }
}
