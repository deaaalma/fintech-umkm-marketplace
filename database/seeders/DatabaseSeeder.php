<?php

namespace Database\Seeders;

use App\Models\Bank_account;
use App\Models\BankAccount;
use App\Models\Order_assignment;
use App\Models\Order_log;
use App\Models\Order;
use App\Models\OrderAssignment;
use App\Models\OrderLog;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Umkm_schedule;
use App\Models\Umkm_worker;
use App\Models\Umkm;
use App\Models\UmkmSchedule;
use App\Models\UmkmWorker;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Gunakan format Indonesia
        $password = Hash::make('password'); // Default password: password

        $this->command->info('Memulai proses seeding database... Mohon tunggu sebentar.');

        // ==========================================
        // 1. AKUN SUPER ADMIN
        // ==========================================
        User::create([
            'name' => 'Super Administrator',
            'phone' => '081111111111',
            'role' => 'superadmin',
            'email' => 'admin@gmail.com',
            'password' => $password,
            'email_verified_at' => now(),
        ]);
        $this->command->info('✅ Super Admin berhasil dibuat.');

        // ==========================================
        // 2. WORKERS (50 Orang)
        // ==========================================
        $workers = [];
        for ($i = 1; $i <= 30; $i++) {
            $workers[] = User::create([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'role' => 'worker',
                'email' => "worker{$i}@gmail.com",
                'password' => $password,
                'email_verified_at' => now(),
            ]);
        }
        $this->command->info('✅ 30 Worker berhasil dibuat.');

        // ==========================================
        // 3. ADMIN UMKM & DATA UMKM (30 UMKM)
        // ==========================================
        $umkms = [];
        $products = [];
        $umkmStatuses = ['active', 'active', 'active', 'pending_verification', 'suspended']; // Rasio banyak yang active

        for ($i = 1; $i <= 30; $i++) {
            // Buat Owner
            $owner = User::create([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'role' => 'admin_umkm',
                'email' => "umkm{$i}@gmail.com",
                'password' => $password,
                'email_verified_at' => now(),
            ]);

            // Rekening Owner
            BankAccount::create([
                'user_id' => $owner->id,
                'bank_name' => $faker->randomElement(['BCA', 'Mandiri', 'BNI', 'BRI', 'BSI']),
                'account_number' => $faker->numerify('##########'),
                'account_holder_name' => $owner->name,
                'is_primary' => 1,
            ]);

            // Buat UMKM
            $companyName = $faker->company . ' ' . $faker->randomElement(['Service', 'Laundry', 'Cleaning', 'Catering', 'Bengkel']);
            $umkm = Umkm::create([
                'owner_id' => $owner->id,
                'name' => $companyName,
                'slug' => Str::slug($companyName) . '-' . $i,
                'description' => $faker->paragraph(3),
                'address' => $faker->address,
                'is_verified' => 1,
                'status' => $faker->randomElement($umkmStatuses),
            ]);
            $umkms[] = $umkm;

            // Jadwal Buka (Senin-Jumat buka, Sabtu-Minggu random)
            for ($day = 1; $day <= 7; $day++) {
                UmkmSchedule::create([
                    'umkm_id' => $umkm->id,
                    'day_of_week' => $day,
                    'open_time' => '08:00:00',
                    'close_time' => '17:00:00',
                    'is_closed' => $day > 5 ? $faker->boolean(40) : 0, // Weekend kadang tutup
                ]);
            }

            // Assign 2-4 worker random ke UMKM ini
            $assignedWorkers = $faker->randomElements($workers, $faker->numberBetween(2, 4));
            foreach ($assignedWorkers as $worker) {
                UmkmWorker::create([
                    'umkm_id' => $umkm->id,
                    'user_id' => $worker->id,
                    'specialization' => $faker->jobTitle,
                    'joined_at' => $faker->dateTimeThisYear()->format('Y-m-d'),
                ]);
            }

            // Buat 3-5 Produk per UMKM
            for ($p = 1; $p <= $faker->numberBetween(3, 5); $p++) {
                $products[] = Product::create([
                    'umkm_id' => $umkm->id,
                    'type' => $faker->randomElement(['jasa', 'barang']),
                    'name' => 'Paket ' . $faker->words(2, true),
                    'description' => $faker->sentence(),
                    'estimated_price' => $faker->numberBetween(5, 50) * 10000, // 50rb - 500rb
                    'duration_minutes' => $faker->randomElement([60, 90, 120, 180]),
                    'is_active' => 1,
                ]);
            }
        }
        $this->command->info('✅ 30 UMKM beserta Produk & Jadwal berhasil dibuat.');

        // ==========================================
        // 4. CUSTOMERS (100 Orang)
        // ==========================================
        $customers = [];
        for ($i = 1; $i <= 100; $i++) {
            $customers[] = User::create([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'role' => 'customer',
                'email' => "customer{$i}@gmail.com",
                'password' => $password,
                'email_verified_at' => now(),
            ]);
        }
        $this->command->info('✅ 100 Customer berhasil dibuat.');

        // ==========================================
        // 5. ORDERS & TRANSACTIONS (200 Transaksi)
        // ==========================================
        $orderStatuses = ['pending_valuation', 'waiting_payment', 'paid', 'processing', 'completed', 'completed', 'completed', 'cancelled'];
        
        for ($i = 1; $i <= 200; $i++) {
            $customer = $faker->randomElement($customers);
            $product = $faker->randomElement($products);
            $umkm = Umkm::find($product->umkm_id); // Ambil umkm dari produk terkait
            
            $price = $product->estimated_price;
            $platformFee = $price * 0.10; // Komisi 10%
            $netIncome = $price - $platformFee;
            $status = $faker->randomElement($orderStatuses);

            // Buat Order
            $order = Order::create([
                'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'customer_id' => $customer->id,
                'umkm_id' => $umkm->id,
                'product_id' => $product->id,
                'booking_date' => $faker->dateTimeBetween('-2 months', '+1 month')->format('Y-m-d'),
                'booking_time' => $faker->time('H:i:00'),
                'service_address' => $faker->address,
                'service_latitude' => $faker->latitude(-8.8, -8.1), // Area Bali sbg contoh
                'service_longitude' => $faker->longitude(114.9, 115.5),
                'notes' => $faker->sentence(),
                'agreed_price' => $price,
                'platform_fee' => $platformFee,
                'umkm_net_income' => $netIncome,
                'status' => $status,
            ]);

            // Jika statusnya sudah bayar atau lebih jauh, buat Payment & Assignment
            if (in_array($status, ['paid', 'processing', 'completed'])) {
                Payment::create([
                    'order_id' => $order->id,
                    'payment_gateway_ref' => 'MIDTRANS-' . strtoupper(Str::random(10)),
                    'payment_method' => $faker->randomElement(['qris', 'bank_transfer', 'ewallet']),
                    'amount' => $price,
                    'status' => 'success',
                    'paid_at' => now()->subDays(rand(1, 30)),
                ]);

                // Assign worker secara random dari UMKM terkait
                $umkmWorkers = UmkmWorker::where('umkm_id', $umkm->id)->get();
                if ($umkmWorkers->count() > 0) {
                    $assignedWorker = $umkmWorkers->random();
                    OrderAssignment::create([
                        'order_id' => $order->id,
                        'worker_id' => $assignedWorker->user_id,
                        'admin_instructions' => $faker->sentence(),
                        'worker_fee' => $netIncome * 0.40, // Worker dapat 40% dari bersih UMKM
                        'is_fee_disbursed' => $status === 'completed' ? 1 : 0,
                        'assigned_at' => now()->subDays(rand(1, 30)),
                        'status' => $status === 'completed' ? 'finished' : 'working',
                    ]);
                }
            }

            // Order Log
            OrderLog::create([
                'order_id' => $order->id,
                'actor_id' => $customer->id,
                'action' => 'order_created',
                'new_value' => 'Order dibuat oleh sistem',
            ]);
        }
        $this->command->info('✅ 200 Order beserta log & payment berhasil dibuat.');
        $this->command->info('🎉 SEEDING SELESAI! Selamat mencoba aplikasinya.');
    }
}