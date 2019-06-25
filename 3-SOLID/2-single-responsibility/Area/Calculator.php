<?php

namespace Geometry\Area;

class Calculator {
    protected $shapes;
    public function __construct(array $shapes = []) {
        $this->shapes = $shapes;
    }

    public function sum() {
        foreach($this->shapes as $shape) {
            if($shape instanceof \Geometry\Square) {
                $area[] = pow($shape->length(), 2);
            } else if($shape instanceof \Geometry\Circle) {
                $area[] = pi() * pow($shape->radius(), 2);
            } else if($shape instanceof \Geometry\Cube) {
                $area[] = pow($shape->length(), 2) * 6;
            }
        }

        return (float)array_sum($area);
    }
}