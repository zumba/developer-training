<?php

namespace Geometry\Area;

class DoubleCalculator extends Calculator {
    public function sum() {
        $sum = parent::sum();
        return [$sum, $sum];
    }
}