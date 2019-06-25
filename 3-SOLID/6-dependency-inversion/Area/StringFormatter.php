<?php

namespace Geometry\Area;

class StringFormatter {
    protected $calc;
    public function __construct(\Geometry\Summable $calc) { 
        $this->calc = $calc;
    }
    public function output() : string {
        return sprintf("Sum of the areas of all shapes: %f\n", $this->calc->sum());
    }
}