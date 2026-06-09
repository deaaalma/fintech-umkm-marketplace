<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$logs = App\Models\OrderLog::where('action', 'Payment Verified')->get();
foreach($logs as $log) {
    if(!App\Models\OrderLog::where('order_id', $log->order_id)->where('action', 'Order Completed')->exists()) {
        App\Models\OrderLog::create([
            'order_id' => $log->order_id,
            'actor_id' => $log->actor_id,
            'action' => 'Order Completed',
            'reason' => 'Pesanan telah selesai. Menunggu penilaian (rating) dan ulasan dari pelanggan.',
            'created_at' => $log->created_at->addSeconds(1),
            'updated_at' => $log->updated_at->addSeconds(1)
        ]);
        echo 'Added for order ' . $log->order_id . PHP_EOL;
    }
}
echo "Done.\n";
