<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Order;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan format Indonesia

        // Definisi pilihan enum dan metode
        $methods = ['Transfer Bank', 'E-Wallet', 'Cash', 'Credit Card'];
        $statuses = ['pending', 'success', 'failed', 'refunded'];

        // Cek apakah tabel orders sudah ada isinya
        $orderIds = Order::pluck('id')->toArray();

        // Jika belum ada order sama sekali, kita buatkan data dummy tanpa relasi ketat (hanya untuk testing)
        // Namun sangat disarankan tabel orders sudah di-seed terlebih dahulu.
        $totalToSeed = !empty($orderIds) ? count($orderIds) : 50;

        for ($i = 0; $i < $totalToSeed; $i++) {
            $status = $faker->randomElement($statuses);
            
            // Membuat tanggal transaksi acak dalam 30 hari terakhir
            $createdAt = Carbon::instance($faker->dateTimeBetween('-30 days', 'now'));
            
            // Jika sukses, set waktu bayar (paid_at) beberapa menit setelah created_at
            $paidAt = null;
            if ($status === 'success' || $status === 'refunded') {
                $paidAt = (clone $createdAt)->addMinutes(rand(2, 120));
            }

            Payment::create([
                // Gunakan ID order asli jika ada, jika tidak gunakan angka acak
                'order_id' => !empty($orderIds) ? $orderIds[$i] : rand(1, 20),
                
                // Generate Ref seperti: PAY-ABCDE-12345
                'payment_gateway_ref' => 'PAY-' . strtoupper($faker->bothify('?????-#####')),
                
                'payment_method' => $faker->randomElement($methods),
                
                // Nominal acak kelipatan 10.000 antara 50rb - 2jt
                'amount' => $faker->numberBetween(5, 200) * 10000,
                
                'status' => $status,
                'paid_at' => $paidAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}