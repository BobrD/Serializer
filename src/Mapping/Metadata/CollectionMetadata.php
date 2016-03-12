<?php

namespace BobrD\Serializer\Mapping\Metadata;

class CollectionMetadata extends TypeMetadata
{
    /**
     * @var TypeMetadata
     */
    private $itemType;

    /**
     * @param TypeMetadata $itemType
     */
    public function __construct($itemType)
    {
        parent::__construct('array');

        $this->itemType = $itemType;
    }

    /**
     * @return TypeMetadata string
     */
    public function getItemType()
    {
        return $this->itemType;
    }
}
