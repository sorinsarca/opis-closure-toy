<?php

require_once __DIR__ . '/autoload.php';

// Calc ini time
$ms = microtime(true);
\Opis\Closure\SerializableClosure::init();
$ms = number_format((microtime(true) - $ms) * 1000, 4);


// Test serialization

$arr = ["works", "ok"];
$arr[] = &$arr;

$f = function (int $x) use (&$arr, &$f) {
    $r = $arr[2][$x];

    if ($x > 0) {
        $r .= ', ' . $f($x - 1);
    }

    return $r;
};

$st = microtime(true);
$serialized = serialize($f);
$st = number_format((microtime(true) - $st) * 1000, 4);


$ut = microtime(true);
$unserialized = unserialize($serialized);
$ut = number_format((microtime(true) - $ut) * 1000, 4);

$result = $unserialized(1); // should be ok, works

echo "<pre>";
echo "Using PHP " . \PHP_VERSION . "\n\n";
echo "Server " . $_SERVER['SERVER_SOFTWARE'] . "\n\n";
echo "Init time: {$ms}ms\n";
echo "Serialization time: {$st}ms\n";
echo "Unserialization time: {$ut}ms\n\n";
echo "Result: ${result}\n\n";
echo "Serialized data:\n";
echo htmlspecialchars($serialized), "\n\n";
echo "</pre>";

flush();
