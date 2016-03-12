<?php

namespace BobrD\Serializer\Tests\Fixtures;

use BobrD\Serializer\Annotation as Serializer;

class User
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Name("e-mail")
     */
    private $email;

    /**
     * @var Address
     *
     * @Serializer\Type("BobrD\Serializer\Tests\Fixtures\Address")
     * @Serializer\Group({"full"})
     */
    private $address;

    /**
     * @var Phone[]
     *
     * @Serializer\Collection("BobrD\Serializer\Tests\Fixtures\Phone")
     */
    private $phones = [];

    /**
     * @param string  $name
     * @param string  $email
     * @param Address $address
     * @param Phone[] $phones
     */
    public function __construct($name, $email, $address, array $phones)
    {
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->phones = $phones;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return Phone[]
     */
    public function getPhones()
    {
        return $this->phones;
    }
}
