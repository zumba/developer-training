<?php

namespace Geometry\Area;

use \Geometry\Shape;

class Calculator implements \Geometry\Summable {
    protected $shapes;
    public function __construct(Shape ...$shapes) {
        $this->shapes = $shapes;
    }

    public function sum() : float {
        foreach($this->shapes as $shape) {
            $area[] = $shape->area();
        }
        return (float)array_sum($area);
    }
}