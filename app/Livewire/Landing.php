<?php

namespace App\Livewire;

use App\Models\Umkm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class Landing extends Component
{
    public function render()
    {
        // Mengambil 10 UMKM aktif terbaru
        $apps = Umkm::where('status', 'active')
            ->select('name', 'logo_url as logo') // Sesuaikan dengan kolom di umkm2.sql
            ->limit(10)
            ->get();

        $logoIpsums = [
            'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-389-Hc8XBOUI8vkVmIwWQZs33kxMF353Xj.png',
            'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-407-eyikTTM6ccO0f4I7ZmNk5LpFI4EKOG.png',
            'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-379-5hDaxwIw4LzjwXzWuorEXi7ESrGYl1.png',
            'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-374-bp0RaoVnQI1JMqR9fjessWI8v33kLV.png',
            'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-381-eKw7vkCp2Wq9hivZJaN1ERJdjCqR0d.png',
            'https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logoipsum-401-F6mjMLGEZt4HAohKA889Z8Gf5fMzIw.png',
        ];

        // Pakai logo statis (logoipsum) agar tidak menampilkan foto produk di slider
        $apps->transform(function ($app, $index) use ($logoIpsums) {
            $app->logo = $logoIpsums[$index % count($logoIpsums)];
            return $app;
        });

        // Jika data di database masih kosong (saat dev), kita buatkan dummy agar tidak error
        if ($apps->isEmpty()) {
            $apps = collect(array_map(function ($logo, $index) {
                return ['name' => 'Mitra ' . ($index + 1), 'logo' => $logo];
            }, array_slice($logoIpsums, 0, 3), array_keys(array_slice($logoIpsums, 0, 3))));
        }
        return view('livewire.landing', compact('apps'));
    }
}
