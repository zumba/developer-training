<?php

namespace Geometry\Area;

class HTMLFormatter {
    protected $calc;
    public function __construct(\Geometry\Summable $calc) { 
        $this->calc = $calc;
    }
    public function output() : string {
        return sprintf("<p>Sum of the areas of all shapes: %f</p>\n", $this->calc->sum());
    }
}