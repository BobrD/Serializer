<?php

namespace BobrD\Serializer\Mapping\Loader\Annotation;

interface AnnotationLoaderAwareInterface
{
    /**
     * @param AnnotationLoader $annotationLoader
     */
    public function setAnnotationLoader(AnnotationLoader $annotationLoader);
}
