<?php

namespace Geometry;

class Square {
    protected $length;
    public function __construct(float $length) {
        $this->length = $length;
    }
    public function length() : float {
        return $this->length;
    }
}