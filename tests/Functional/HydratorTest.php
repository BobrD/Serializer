<?php

namespace BobrD\Serializer\Tests\Functional;

use BobrD\Serializer\Hydrator;
use BobrD\Serializer\Mapping\Loader\Annotation\AnnotationLoader;
use BobrD\Serializer\Tests\Fixtures\User;
use Doctrine\Common\Annotations\AnnotationReader;

class HydratorTest extends \PHPUnit_Framework_TestCase
{
    public function testHydrate()
    {
        $metaData = $this->createMetadata();

        $hydrator = new Hydrator();

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

        /** @var User $user */
        $user = $hydrator->hydrate($data, $metaData, ['groups' => ['full']]);

        $this->assertInstanceOf(User::class, $user);

        $this->assertEquals('Eugene', $user->getName());
        $this->assertEquals('eguene.bober@gamil.com', $user->getEmail());
        $this->assertEquals('Baker street', $user->getAddress()->getStreet());
        $this->assertCount(3, $user->getPhones());

        $this->assertEquals('123', $user->getPhones()[0]->getNumber());
    }

    private function createMetadata()
    {
        $loader = new AnnotationLoader(new AnnotationReader());

        return $loader->loadMetadata(User::class);
    }
}
