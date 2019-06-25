<?php

require_once 'Shape.php';
require_once 'Circle.php';
require_once 'Cube.php';
require_once 'Square.php';
require_once 'Area/Calculator.php';
require_once 'Area/HTMLFormatter.php';
require_once 'Area/JSONFormatter.php';
require_once 'Area/StringFormatter.php';

$shapes = [
    new \Geometry\Circle(7.5),
    new \Geometry\Square(1.0),
    new \Geometry\Cube(10.3)
];

echo (new \Geometry\Area\StringFormatter(...$shapes))->output();
echo (new \Geometry\Area\HTMLFormatter(...$shapes))->output();
echo (new \Geometry\Area\JSONFormatter(...$shapes))->output();