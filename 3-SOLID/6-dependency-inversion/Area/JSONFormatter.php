<?php

namespace Geometry\Area;

class JSONFormatter {
    protected $calc;
    public function __construct(\Geometry\Summable $calc) { 
        $this->calc = $calc;
    }
    public function output() : string {
        return sprintf("{\"sum\":%f}\n", $this->calc->sum());
    }
}