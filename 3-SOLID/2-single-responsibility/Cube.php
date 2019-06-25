<?php

namespace Geometry;

class Cube {
    protected $length;
    public function __construct(float $length) {
        $this->length = $length;
    }
    public function length() : float {
        return $this->length;
    }
}