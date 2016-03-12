<?php

namespace BobrD\Serializer;

interface ExtractorAwareInterface
{
    /**
     * @param ExtractorInterface $extractor
     */
    public function setExtractor(ExtractorInterface $extractor);
}
