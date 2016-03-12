<?php

namespace BobrD\Serializer\ExcludeVoter;

use BobrD\Serializer\Mapping\Metadata\GroupMetadata;
use BobrD\Serializer\Mapping\Metadata\PropertyMetadata;

class GroupExcludeVoter implements ExcludeVoterInterface
{
    /**
     * {@inheritdoc}
     */
    public function vote(PropertyMetadata $propertyMetadata, array $context = [])
    {
        /** @var GroupMetadata $groupMetadata */
        $groupMetadata = $propertyMetadata->getMetadata(GroupMetadata::class);

        if (null === $groupMetadata) {
            return false;
        }

        // metadata has groups, but context empty
        if (!$this->contextHasGroups($context)) {
            return true;
        }

        $metadataGroups = $groupMetadata->getGroups();
        $contextGroups = $context['groups'];

        foreach ($contextGroups as $contextGroup) {
            if (in_array($contextGroup, $metadataGroups)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $context
     * 
     * @return bool
     */
    private function contextHasGroups(array $context)
    {
        if (!isset($context['groups']) || 0 === count($context['groups'])) {
            return false;
        }

        return true;
    }
}
