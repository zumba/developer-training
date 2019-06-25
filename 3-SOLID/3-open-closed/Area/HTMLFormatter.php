<?php

namespace Geometry\Area;

use \Geometry\Shape;

class HTMLFormatter {
    protected $calc;
    public function __construct(Shape ...$shapes) { 
        $this->calc = new Calculator(...$shapes);
    }
    public function output() : string {
        return sprintf("<p>Sum of the areas of all shapes: %f</p>\n", $this->calc->sum());
    }
}