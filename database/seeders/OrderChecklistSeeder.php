<?php

namespace Database\Seeders;

use App\Models\OrderChecklist;
use App\Models\Umkm;
use Illuminate\Database\Seeder;

class OrderChecklistSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua UMKM yang ada, seed untuk masing-masing
        $umkms = Umkm::all();

        if ($umkms->isEmpty()) {
            $this->command->warn('Tidak ada UMKM di database. Skipping OrderChecklistSeeder.');
            return;
        }

        $defaultItems = [
            ['label' => 'Persiapan alat dan peralatan kebersihan', 'sort_order' => 1],
            ['label' => 'Briefing awal dengan customer', 'sort_order' => 2],
            ['label' => 'Pembersihan area utama', 'sort_order' => 3],
            ['label' => 'Pembersihan area sekunder', 'sort_order' => 4],
            ['label' => 'Quality check hasil kerja', 'sort_order' => 5],
            ['label' => 'Rapikan peralatan dan pamit ke customer', 'sort_order' => 6],
        ];

        foreach ($umkms as $umkm) {
            // Hindari duplikasi jika seeder dijalankan ulang
            if (OrderChecklist::where('umkm_id', $umkm->id)->exists()) {
                $this->command->info("UMKM [{$umkm->name}] sudah punya checklist, di-skip.");
                continue;
            }

            foreach ($defaultItems as $item) {
                OrderChecklist::create([
                    'umkm_id'    => $umkm->id,
                    'product_id' => null, // berlaku untuk semua produk UMKM ini
                    'label'      => $item['label'],
                    'sort_order' => $item['sort_order'],
                    'is_active'  => true,
                ]);
            }

            $this->command->info("Seeded 6 checklist items untuk UMKM: {$umkm->name}");
        }
    }
}
