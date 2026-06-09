<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$order = App\Models\Order::find(1502);
if ($order) {
    echo "Order 1502 Status: " . $order->status . "\n";
    echo "Order 1502 Review: " . ($order->review ? "Exists" : "None") . "\n";
    if ($order->review) {
        echo "Review Comment: " . $order->review->comment . "\n";
    }
} else {
    echo "Order 1502 not found\n";
}
