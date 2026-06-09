<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $password = Hash::make('password');
        $now = now();

        $this->command->info('🚀 Memulai seeding dengan skema terbaru (umkm2.sql)...');

        // ==========================================
        // 1. MASTER DATA
        // ==========================================
        $categories = ['Cleaning Service', 'Service AC', 'Laundry', 'Catering & Food', 'IT & Digital Support', 'Desain Grafis'];
        $categoryIds = [];
        foreach ($categories as $category) {
            $categoryIds[] = DB::table('categories')->insertGetId([
                'name' => $category,
                'slug' => Str::slug($category),
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        $issueTypes = ['Resolusi Tiket', 'Pengguna - Policy', 'Masalah Pembayaran', 'Lainnya'];
        $issueTypeIds = [];
        foreach ($issueTypes as $issue) {
            $issueTypeIds[] = DB::table('issue_types')->insertGetId([
                'name' => $issue,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ==========================================
        // 2. USERS (Lengkap dengan NIK & Tanggal Lahir)
        // ==========================================
        
        // Superadmin
        DB::table('users')->insert([
            'name' => 'Super Administrator',
            'phone' => '081111111111',
            'role' => 'superadmin',
            'email' => 'admin@gmail.com',
            'password' => $password,
            'nik' => $faker->numerify('################'),
            'date_of_birth' => '1990-01-01',
            'email_verified_at' => $now, 'created_at' => $now, 'updated_at' => $now,
        ]);

        // Customers (100 orang)
        $customerIds = [];
        for ($i = 1; $i <= 100; $i++) {
            $customerIds[] = DB::table('users')->insertGetId([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'role' => 'customer',
                'email' => "customer{$i}@gmail.com",
                'password' => $password,
                'nik' => $faker->numerify('################'),
                'date_of_birth' => $faker->date('Y-m-d', '-20 years'),
                'email_verified_at' => $now, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // Admin UMKM (30 orang)
        $adminUmkmIds = [];
        for ($i = 1; $i <= 30; $i++) {
            $adminUmkmIds[] = DB::table('users')->insertGetId([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'role' => 'admin_umkm',
                'email' => "umkm{$i}@gmail.com",
                'password' => $password,
                'nik' => $faker->numerify('################'),
                'date_of_birth' => $faker->date('Y-m-d', '-25 years'),
                'email_verified_at' => $now, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // Workers (30 orang)
        $workerIds = [];
        for ($i = 1; $i <= 30; $i++) {
            $workerIds[] = DB::table('users')->insertGetId([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'role' => 'worker',
                'email' => "worker{$i}@gmail.com",
                'password' => $password,
                'nik' => $faker->numerify('################'),
                'date_of_birth' => $faker->date('Y-m-d', '-22 years'),
                'email_verified_at' => $now, 'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ==========================================
        // 3. UMKM & DETAILS (Lengkap dengan Kota, NPWP, Foto)
        // ==========================================
        $productCatalog = [];
        $umkmWorkerMap = [];

        foreach ($adminUmkmIds as $index => $ownerId) {
            // Bank Account
            $bankId = DB::table('bank_accounts')->insertGetId([
                'user_id' => $ownerId,
                'bank_name' => $faker->randomElement(['BCA', 'Mandiri', 'BNI', 'BRI']),
                'account_number' => $faker->numerify('##########'),
                'account_holder_name' => $faker->name,
                'created_at' => $now, 'updated_at' => $now,
            ]);

            // UMKM (Lengkap dengan City)
            $company = $faker->company;
            $umkmId = DB::table('umkms')->insertGetId([
                'owner_id' => $ownerId,
                'application_code' => 'APP-' . date('Y') . '-' . Str::upper(Str::random(5)),
                'category_id' => $faker->randomElement($categoryIds),
                'name' => $company,
                'slug' => Str::slug($company) . '-' . $index,
                'address' => $faker->address,
                'city' => $faker->city, // Kota
                'is_verified' => 1,
                'status' => 'active',
                'created_at' => $now, 'updated_at' => $now,
            ]);

            // UMKM Detail (Lengkap dengan NPWP & Foto Usaha)
            DB::table('umkm_details')->insert([
                'umkm_id' => $umkmId,
                'description' => $faker->paragraph,
                'npwp_file_path' => 'uploads/npwp/dummy.pdf',
                'nib_file_path' => 'uploads/nib/dummy.pdf',
                'ktp_file_path' => 'uploads/ktp/dummy.jpg',
                'photo' => 'uploads/business/storefront.jpg', // Foto tempat usaha
                'contact_person' => $faker->name,
            ]);

            // Schedules
            for ($d = 1; $d <= 7; $d++) {
                DB::table('umkm_schedules')->insert([
                    'umkm_id' => $umkmId, 'day_of_week' => $d,
                    'open_time' => '08:00:00', 'close_time' => '17:00:00',
                    'is_closed' => $d > 5 ? 1 : 0,
                ]);
            }

            // Products
            for ($p = 1; $p <= 3; $p++) {
                $price = $faker->numberBetween(10, 100) * 5000;
                $productId = DB::table('products')->insertGetId([
                    'umkm_id' => $umkmId,
                    'type' => 'jasa',
                    'name' => 'Layanan ' . $faker->word,
                    'estimated_price' => $price,
                    'is_active' => 1,
                    'created_at' => $now, 'updated_at' => $now,
                ]);
                $productCatalog[] = ['id' => $productId, 'umkm_id' => $umkmId, 'price' => $price];
            }

            // Map Workers
            $assignedWorkers = $faker->randomElements($workerIds, 2);
            $umkmWorkerMap[$umkmId] = $assignedWorkers;
            foreach ($assignedWorkers as $wId) {
                DB::table('umkm_workers')->insert([
                    'umkm_id' => $umkmId, 'user_id' => $wId, 'joined_at' => $now, 'created_at' => $now,
                ]);
            }
        }

        // ==========================================
        // 4. ORDERS & REVIEWS
        // ==========================================
        for ($i = 1; $i <= 1500; $i++) {
            $prod = $faker->randomElement($productCatalog);
            $cust = $faker->randomElement($customerIds);
            // Memberikan bobot lebih besar pada 'completed' agar lebih banyak review yang tercipta
            $status = $faker->randomElement(['pending_valuation', 'waiting_payment', 'paid', 'processing', 'completed', 'completed', 'completed', 'completed']);

            $orderId = DB::table('orders')->insertGetId([
                'invoice_number' => 'INV-' . date('Ymd') . '-' . Str::upper(Str::random(6)),
                'customer_id' => $cust,
                'umkm_id' => $prod['umkm_id'],
                'product_id' => $prod['id'],
                'booking_date' => $now->format('Y-m-d'),
                'service_address' => $faker->address,
                'agreed_price' => $prod['price'],
                'status' => $status,
                'created_at' => $now, 'updated_at' => $now,
            ]);

            if ($status === 'completed') {
                DB::table('order_reviews')->insert([
                    'order_id' => $orderId,
                    'customer_id' => $cust,
                    'umkm_id' => $prod['umkm_id'],
                    'rating' => $faker->numberBetween(3, 5),
                    'comment' => $faker->sentence,
                    'issue_type_id' => $faker->boolean(20) ? $faker->randomElement($issueTypeIds) : null,
                    'created_at' => $now,
                ]);
            }
        }

        $this->command->info('✅ Seeding Selesai! Data Kota, NIK, NPWP, dan Foto Usaha sudah masuk.');
    }
}