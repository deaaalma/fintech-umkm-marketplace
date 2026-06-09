<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Umkm;
use App\Models\Product;

$categoryImages = [
    1 => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&q=80', // Cleaning (Updated, known working)
    2 => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&q=80', // Service AC (Works)
    3 => 'https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?w=800&q=80', // Laundry (Works)
    4 => 'https://images.unsplash.com/photo-1555244162-803834f70033?w=800&q=80', // Catering & Food (Works)
    5 => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&q=80', // IT
    6 => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=800&q=80', // Desain Grafis (Updated)
];

foreach (Umkm::all() as $umkm) {
    if (isset($categoryImages[$umkm->category_id])) {
        $umkm->logo_url = $categoryImages[$umkm->category_id];
        $umkm->save();
    }
}

foreach (Product::all() as $product) {
    if (isset($categoryImages[$product->category_id])) {
        $product->image_url = $categoryImages[$product->category_id];
        $product->save();
    } elseif ($product->umkm && isset($categoryImages[$product->umkm->category_id])) {
        $product->image_url = $categoryImages[$product->umkm->category_id];
        $product->save();
    }
}

echo "Berhasil update dummy images!";
