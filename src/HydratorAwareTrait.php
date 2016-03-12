<?php

namespace BobrD\Serializer;

trait HydratorAwareTrait
{
    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }
}
