<?php

namespace BobrD\Serializer\Tests\Fixtures;

use BobrD\Serializer\Annotation as Serializer;

class Phone
{
    /**
     * @var string
     * 
     * @Serializer\Type("string")
     */
    private $number;

    /**
     * @param string $number
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
}
