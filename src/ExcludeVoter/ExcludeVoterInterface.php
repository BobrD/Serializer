<?php

namespace BobrD\Serializer\ExcludeVoter;

use BobrD\Serializer\Mapping\Metadata\PropertyMetadata;

interface ExcludeVoterInterface
{
    /**
     * @param PropertyMetadata $propertyMetadata
     * @param array            $context
     * 
     * @return bool
     */
    public function vote(PropertyMetadata $propertyMetadata, array $context = []);
}
