<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hapus data pesanan lama secara aman (ignore FK check sementara)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Order::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Ambil data pendukung
        $umkms = Umkm::all();
        if ($umkms->isEmpty()) {
            $this->command->warn('Tidak ada UMKM di database. Silakan seed UMKM terlebih dahulu.');
            return;
        }

        $customers = User::where('role', 'customer')->orWhere('role', 'user')->get();
        if ($customers->isEmpty()) {
            $customers = User::all();
        }

        $statuses = ['pending_valuation', 'waiting_payment', 'paid', 'processing', 'completed', 'cancelled'];
        
        $this->command->info('mengenerate 200 data transaksi variatif (6 bulan terakhir)');

        // 3. Buat 200 transaksi untuk mengisi grafik agar ramai dan merata
        for ($i = 0; $i < 200; $i++) {
            $umkm = $umkms->random();
            $customer = $customers->random();
            $product = Product::where('umkm_id', $umkm->id)->first();
            if (!$product) continue;

            $price = rand(10, 250) * 10000; // Rp 100rb - Rp 2.5jt
            $fee = $price * 0.1;
            $status = $statuses[array_rand($statuses)];
            
            // Sebarkan tanggal merata (0 sampai 180 hari ke belakang)
            $date = Carbon::now()->subDays(rand(0, 180))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            Order::create([
                'invoice_number' => in_array($status, ['paid', 'completed', 'processing']) ? 'INV/' . $date->format('Ymd') . '/' . strtoupper(Str::random(5)) : null,
                'customer_id' => $customer->id,
                'umkm_id' => $umkm->id,
                'product_id' => $product->id,
                'booking_date' => $date->toDateString(),
                'booking_time' => $date->toTimeString(),
                'service_address' => 'Jl. Testing No. ' . rand(1, 100),
                'service_latitude' => $umkm->latitude,
                'service_longitude' => $umkm->longitude,
                'notes' => 'Generated data for testing analytics.',
                'agreed_price' => $price,
                'platform_fee' => $fee,
                'umkm_net_income' => $price - $fee,
                'status' => $status,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        $this->command->info('150 data transaksi dummy berhasil disebar');
    }
}
