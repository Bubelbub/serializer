<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace JMS\SerializerBundle\Serializer\Naming;

use JMS\SerializerBundle\Annotation\SerializedName;

use Doctrine\Common\Annotations\AnnotationReader;

class AnnotatedNamingStrategy implements PropertyNamingStrategyInterface
{
    private $reader;
    private $delegate;

    public function __construct(AnnotationReader $reader, PropertyNamingStrategyInterface $namingStrategy)
    {
        $this->reader = $reader;
        $this->delegate = $namingStrategy;
    }

    public function translateName(\ReflectionProperty $property)
    {
        $annotations = $this->reader->getPropertyAnnotations($property);

        foreach ($annotations as $annotation) {
            if ($annotation instanceof SerializedName) {
                return $annotation->getName();
            }
        }

        return $this->delegate->translateName($property);
    }
}