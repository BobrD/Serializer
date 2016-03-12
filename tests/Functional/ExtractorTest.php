<?php

namespace BobrD\Serializer\Tests\Functional;

use BobrD\Serializer\Extractor;
use BobrD\Serializer\Mapping\Loader\Annotation\AnnotationLoader;
use BobrD\Serializer\Tests\Fixtures\Address;
use BobrD\Serializer\Tests\Fixtures\Phone;
use BobrD\Serializer\Tests\Fixtures\User;
use Doctrine\Common\Annotations\AnnotationReader;

class ExtractorTest extends \PHPUnit_Framework_TestCase
{
    public function testExtact()
    {
        $metaData = $this->createMetadata();

        $extractor = new Extractor();

        $user = new User(
            'Eugene',
            'eguene.bober@gamil.com',
            new Address('Baker street'),
            [
                new Phone('123'),
                new Phone('234'),
                new Phone('456'),
            ]
        );

        $data = [
            'name' => 'Eugene',
            'e-mail' => 'eguene.bober@gamil.com',
            'address' => [
                'street' => 'Baker street',
            ],
            'phones' => [
                ['number' => '123'],
                ['number' => '234'],
                ['number' => '456'],
            ],
        ];

        /* @var User $user */
        $result = $extractor->extract($user, $metaData, ['groups' => ['full']]);

        $this->assertEquals($data, $result);
    }

    private function createMetadata()
    {
        $loader = new AnnotationLoader(new AnnotationReader());

        return $loader->loadMetadata(User::class);
    }
}
