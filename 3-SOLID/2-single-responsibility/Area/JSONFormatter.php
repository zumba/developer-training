<?php

namespace Geometry\Area;

class JSONFormatter {
    protected $calc;
    public function __construct(array $shapes = []) { 
        $this->calc = new Calculator($shapes);
    }
    public function output() : string {
        return sprintf("{\"sum\":%f}\n", $this->calc->sum());
    }
}