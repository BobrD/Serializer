<?php

namespace BobrD\Serializer\Tests\Fixtures;

use BobrD\Serializer\Annotation as Serializer;

class Address
{
    /**
     * @var string
     * 
     * @Serializer\Type("string")
     */
    private $street;

    /**
     * @param string $street
     */
    public function __construct($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }
}
