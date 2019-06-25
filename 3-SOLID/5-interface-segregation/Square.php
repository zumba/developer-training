<?php

namespace Geometry;

class Square implements Shape {
    protected $length;
    public function __construct(float $length) {
        $this->length = $length;
    }
    public function area() : float {
        return pow($this->length, 2);
    }
}