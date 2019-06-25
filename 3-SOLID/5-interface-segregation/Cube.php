<?php

namespace Geometry;

class Cube implements Shape, Solid {
    protected $length;
    public function __construct(float $length) {
        $this->length = $length;
    }
    public function area() : float {
        return pow($this->length, 2) * 6;
    }

    public function volume() : float {
        return pow($this->length, 3);
    }
}