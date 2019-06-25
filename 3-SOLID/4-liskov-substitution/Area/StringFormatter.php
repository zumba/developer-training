<?php

namespace Geometry\Area;

use \Geometry\Shape;

class StringFormatter {
    protected $calc;
    public function __construct(Shape ...$shapes) { 
        $this->calc = new DoubleCalculator(...$shapes);
    }
    public function output() : string {
        return sprintf("Sum of the areas of all shapes: %f\n", $this->calc->sum());
    }
}