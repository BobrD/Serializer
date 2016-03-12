<?php

namespace BobrD\Serializer;

interface HydratorAwareInterface
{
    public function setHydrator(HydratorInterface $hydrator);
}
