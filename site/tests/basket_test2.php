<?php

function calculate_total($items) {
    $sum = 0;
    foreach ($items as $i) {
        $sum += $i['price'] * $i['quantity'];
    }
    return $sum;
}

$items = [
    ['price' => 10.00, 'quantity' => 2],
    ['price' => 5.50, 'quantity' => 1],
];

$expected = 30.50;
$actual = calculate_total($items);

if (abs($expected - $actual) > 0.001) {

    // JSON report ONLY on failure
    $report = [
        'test_name' => 'BasketTotalCalculation',
        'expected'  => $expected,
        'actual'    => $actual,
        'status'    => 'FAILED',
        'message'   => "Expected $expected but got $actual"
    ];

    file_put_contents(
        '/var/www/html/tests/failure_report.json',
        json_encode($report, JSON_PRETTY_PRINT)
    );

    echo "Unit test FAILED\n";
    exit(1);
}

echo "Unit test PASSED\n";
exit(0);
