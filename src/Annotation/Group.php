<?php

namespace BobrD\Serializer\Annotation;

/**
 * @Annotation()
 *
 * @Target({"PROPERTY"})
 */
class Group implements SerializerAnnotationInterface
{
    /**
     * @var array
     */
    private $groups = [];

    public function __construct(array $values)
    {
        $this->groups = $values['value'];
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
