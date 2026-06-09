<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$order = App\Models\Order::latest()->first();
if($order) {
    $order->status = 'processing';
    $order->current_step = 4;
    $order->save();
    echo "Fixed Order ID: " . $order->id;
}
