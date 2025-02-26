<?php

namespace Mgilet\NotificationBundle\Annotation;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Notifiable
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}