<?php

namespace BobrD\Serializer\Annotation;

/**
 * @Annotation()
 *
 * @Target({"PROPERTY"})
 */
class Name implements SerializerAnnotationInterface
{
    /**
     * @var string
     */
    private $name;

    public function __construct(array $values)
    {
        $this->name = $values['value'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
