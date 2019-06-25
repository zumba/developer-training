<?php

namespace Geometry;

class AreaCalculator {
    protected $shapes;
    public function __construct(array $shapes = []) {
        $this->shapes = $shapes;
    }

    public function sum() {
        foreach($this->shapes as $shape) {
            if($shape instanceof Square) {
                $area[] = pow($shape->length(), 2);
            } else if($shape instanceof Circle) {
                $area[] = pi() * pow($shape->radius(), 2);
            } else if($shape instanceof Cube) {
                $area[] = pow($shape->length(), 2) * 6;
            }
        }

        return (float)array_sum($area);
    }

    public function output() : string {
        return sprintf("Sum of the areas of all shapes: %f\n", $this->sum());
    }
}