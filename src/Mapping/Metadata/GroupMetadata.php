<?php

namespace BobrD\Serializer\Mapping\Metadata;

class GroupMetadata implements MetadataInterface
{
    /**
     * @var array
     */
    private $groups = [];

    /**
     * @param array $groups
     */
    public function __construct(array $groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->groups);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->groups = unserialize($serialized);
    }
}
