<?php

namespace Geometry\Area;

use \Geometry\Shape;

class JSONFormatter {
    protected $calc;
    public function __construct(Shape ...$shapes) { 
        $this->calc = new Calculator(...$shapes);
    }
    public function output() : string {
        return sprintf("{\"sum\":%f}\n", $this->calc->sum());
    }
}