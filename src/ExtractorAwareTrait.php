<?php

namespace BobrD\Serializer;

trait ExtractorAwareTrait
{
    /**
     * @var ExtractorInterface
     */
    protected $extractor;

    /**
     * @param ExtractorInterface $extractor
     */
    public function setExtractor(ExtractorInterface $extractor)
    {
        $this->extractor = $extractor;
    }
}
