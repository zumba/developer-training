<?php

namespace Geometry;

class Circle implements Shape {
    protected $radius;
    public function __construct(float $radius) {
        $this->radius = $radius;
    }
    public function area() : float {
        return pi() * pow($this->radius, 2);
    }
}
