<?php

// Simple test for basket total calculation logic
function calculate_total($items) {
    $sum = 0;
    foreach ($items as $i) {
        $sum += $i['price'] * $i['quantity'];
    }
    return $sum;
}

// ---- TEST CASE ----

// Fake basket items
$items = [
    ['price' => 10.00, 'quantity' => 2],  // £20
    ['price' => 5.50, 'quantity' => 1],   // £5.50
];

$expected = 30.50;
$actual = calculate_total($items);

if (abs($expected - $actual) > 0.001) {
    echo "Basket Unit Test FAILED: Expected $expected but got $actual\n";
    exit(1);
}

echo "Basket Unit Test PASSED\n";
exit(0);
