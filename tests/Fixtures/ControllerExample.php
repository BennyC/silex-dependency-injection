<?php

namespace Fudge\SilexComponents\DependencyInjection\Fixtures;

class ControllerExample
{
    public function __construct(Foo $bar)
    {
        $this->bar = $bar;
    }

    public function getFoo()
    {
        return $this->bar;
    }
}
