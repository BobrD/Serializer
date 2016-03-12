<?php

namespace BobrD\Serializer\Mapping\Loader;

use BobrD\Serializer\Mapping\Metadata\TypeMetadata;

interface MetadataLoaderInterface
{
    /**
     * @param mixed $type
     * 
     * @return TypeMetadata
     */
    public function loadMetadata($type);
}
