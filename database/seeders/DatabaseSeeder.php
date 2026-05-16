<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $defaultPassword = Hash::make('password'); // Semua password adalah 'password'

        // ==========================================
        // 1. SEED USERS (Buat 4 Role Berbeda)
        // ==========================================
        $superAdminId = DB::table('users')->insertGetId([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => $defaultPassword,
            'phone' => '0811111111',
            'role' => 'superadmin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $adminUmkmId = DB::table('users')->insertGetId([
            'name' => 'Budi Pemilik UMKM',
            'email' => 'budi.umkm@gmail.com',
            'password' => $defaultPassword,
            'phone' => '0822222222',
            'role' => 'admin_umkm',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $workerId = DB::table('users')->insertGetId([
            'name' => 'Asep Teknisi',
            'email' => 'asep.worker@gmail.com',
            'password' => $defaultPassword,
            'phone' => '0833333333',
            'role' => 'worker',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $customerId = DB::table('users')->insertGetId([
            'name' => 'Siti Customer',
            'email' => 'siti.customer@gmail.com',
            'password' => $defaultPassword,
            'phone' => '0844444444',
            'role' => 'customer',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ==========================================
        // 2. SEED USER DEVICES (Device milik Customer)
        // ==========================================
        DB::table('user_devices')->insert([
            'user_id' => $customerId,
            'fcm_token' => 'dummy_token_abc123',
            'device_type' => 'android',
            'updated_at' => $now,
        ]);

        // ==========================================
        // 3. SEED BANK ACCOUNTS
        // ==========================================
        $bankOwnerId = DB::table('bank_accounts')->insertGetId([
            'user_id' => $adminUmkmId,
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder_name' => 'Budi Pemilik UMKM',
            'is_primary' => true,
        ]);

        $bankWorkerId = DB::table('bank_accounts')->insertGetId([
            'user_id' => $workerId,
            'bank_name' => 'Mandiri',
            'account_number' => '0987654321',
            'account_holder_name' => 'Asep Teknisi',
            'is_primary' => true,
        ]);

        // ==========================================
        // 4. SEED UMKMS
        // ==========================================
        $umkmId = DB::table('umkms')->insertGetId([
            'owner_id' => $adminUmkmId,
            'name' => 'Budi Service AC',
            'slug' => 'budi-service-ac',
            'description' => 'Melayani perbaikan AC panggilan terpercaya.',
            'address' => 'Jl. Merdeka No 10, Jakarta',
            'is_verified' => true,
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ==========================================
        // 5. SEED UMKM SCHEDULES (Senin - Jumat)
        // ==========================================
        for ($i = 1; $i <= 5; $i++) {
            DB::table('umkm_schedules')->insert([
                'umkm_id' => $umkmId,
                'day_of_week' => $i,
                'open_time' => '08:00:00',
                'close_time' => '17:00:00',
                'is_closed' => false,
            ]);
        }

        // ==========================================
        // 6. SEED UMKM WORKERS
        // ==========================================
        DB::table('umkm_workers')->insert([
            'umkm_id' => $umkmId,
            'user_id' => $workerId,
            'specialization' => 'Teknisi AC Split',
            'joined_at' => $now->toDateString(),
            'is_active' => true,
        ]);

        // ==========================================
        // 7. SEED PRODUCTS
        // ==========================================
        $productId = DB::table('products')->insertGetId([
            'umkm_id' => $umkmId,
            'type' => 'jasa',
            'name' => 'Cuci AC 1/2 - 1 PK',
            'description' => 'Layanan cuci AC menyeluruh luar dan dalam.',
            'estimated_price' => 75000.00,
            'duration_minutes' => 60,
            'is_active' => true,
            'created_at' => $now,
        ]);

        // ==========================================
        // 8. SEED PRODUCT GALLERIES
        // ==========================================
        DB::table('product_galleries')->insert([
            'product_id' => $productId,
            'image_url' => 'products/cuci_ac.jpg',
            'is_featured' => true,
        ]);

        // ==========================================
        // 9. SEED ORDERS
        // ==========================================
        $orderId = DB::table('orders')->insertGetId([
            'invoice_number' => 'INV-20260311-0001',
            'customer_id' => $customerId,
            'umkm_id' => $umkmId,
            'product_id' => $productId,
            'booking_date' => $now->copy()->addDays(1)->toDateString(),
            'booking_time' => '10:00:00',
            'service_address' => 'Jl. Kenangan No 99, Jakarta',
            'service_latitude' => -6.200000,
            'service_longitude' => 106.816666,
            'notes' => 'Tolong bawa tangga, rumah 2 lantai.',
            'agreed_price' => 75000.00,
            'platform_fee' => 5000.00,
            'umkm_net_income' => 70000.00,
            'status' => 'paid', // Status kita anggap sudah dibayar
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ==========================================
        // 10. SEED ORDER ASSIGNMENTS
        // ==========================================
        DB::table('order_assignments')->insert([
            'order_id' => $orderId,
            'worker_id' => $workerId,
            'admin_instructions' => 'Pastikan freon dicek juga ya Sep.',
            'worker_fee' => 40000.00, // Gaji Asep
            'is_fee_disbursed' => false,
            'assigned_at' => $now,
            'status' => 'scheduled',
        ]);

        // ==========================================
        // 11. SEED INVOICES
        // ==========================================
        DB::table('invoices')->insert([
            'order_id' => $orderId,
            'invoice_code' => 'INV-20260311-0001',
            'file_url' => 'invoices/INV-20260311-0001.pdf',
            'generated_at' => $now,
        ]);

        // ==========================================
        // 12. SEED ORDER LOGS
        // ==========================================
        DB::table('order_logs')->insert([
            'order_id' => $orderId,
            'actor_id' => $customerId,
            'action' => 'order_created',
            'new_value' => 'Order dibuat oleh Customer',
            'created_at' => $now,
        ]);

        // ==========================================
        // 13. SEED PAYMENTS
        // ==========================================
        DB::table('payments')->insert([
            'order_id' => $orderId,
            'payment_gateway_ref' => 'MIDTRANS-998877',
            'payment_method' => 'qris',
            'amount' => 75000.00,
            'status' => 'success',
            'paid_at' => $now,
        ]);

        // ==========================================
        // 14. SEED WITHDRAWALS
        // ==========================================
        DB::table('withdrawals')->insert([
            'user_id' => $adminUmkmId,
            'bank_account_id' => $bankOwnerId,
            'amount' => 70000.00,
            'status' => 'requested',
            'admin_note' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
