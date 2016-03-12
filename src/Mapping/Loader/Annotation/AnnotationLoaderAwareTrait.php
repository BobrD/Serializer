<?php

namespace BobrD\Serializer\Mapping\Loader\Annotation;

trait AnnotationLoaderAwareTrait
{
    /**
     * @var AnnotationLoader
     */
    protected $annotationLoader;

    /**
     * @param AnnotationLoader $annotationLoader
     */
    public function setAnnotationLoader(AnnotationLoader $annotationLoader)
    {
        $this->annotationLoader = $annotationLoader;
    }
}
