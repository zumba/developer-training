<?php
require_once 'AreaCalculator.php';
require_once 'Circle.php';
require_once 'Cube.php';
require_once 'Square.php';

$shapes = [
    new \Geometry\Circle(7.5),
    new \Geometry\Square(1.0),
    new \Geometry\Cube(10.3)
];

$calc = new \Geometry\AreaCalculator($shapes);

echo $calc->output();