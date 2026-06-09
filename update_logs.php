<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
App\Models\OrderLog::where('reason', 'like', '%(rating)%')->update(['reason' => 'Pesanan telah selesai. Menunggu penilaian dan ulasan dari pelanggan.']);
echo "Updated existing logs.\n";
