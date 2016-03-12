<?php

namespace BobrD\Serializer\Annotation;

/**
 * @Annotation()
 *
 * @Target({"PROPERTY"})
 */
class Type implements SerializerAnnotationInterface
{
    /**
     * @var string
     */
    private $type;

    public function __construct(array $values)
    {
        $this->type = $values['value'];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
