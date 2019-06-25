<?php

namespace Geometry;

class Circle {
    protected $radius;
    public function __construct(float $radius) {
        $this->radius = $radius;
    }
    public function radius() : float {
        return $this->radius;
    }
}
