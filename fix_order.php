<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;

// Find all orders that have reviews but status is not 'completed' or current_step is not 6
$orders = Order::has('review')->get();

$count = 0;
foreach ($orders as $order) {
    if ($order->status !== 'completed' || $order->current_step !== 6) {
        $order->update([
            'status' => 'completed',
            'current_step' => 6
        ]);
        $count++;
        echo "Updated Order ID: {$order->id} (Status -> completed, Step -> 6)\n";
    }
}

echo "Backfill finished. Updated $count orders.\n";
