<?php

namespace App\Livewire\Worker\Sop;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.worker-layout')]
class Index extends Component
{
    public $search = '';
    public $activeSopId = 2; // Default to SOP Deep Cleaning

    public $sops = [
        ['id' => 1, 'title' => 'SOP Umum', 'icon' => 'document-text'],
        ['id' => 2, 'title' => 'SOP Deep Cleaning', 'icon' => 'sparkles'],
        ['id' => 3, 'title' => 'SOP Office Cleaning', 'icon' => 'office-building'],
        ['id' => 4, 'title' => 'SOP Sofa & Carpet', 'icon' => 'upholstery'],
        ['id' => 5, 'title' => 'Safety Guidelines', 'icon' => 'shield-check'],
        ['id' => 6, 'title' => 'Quality Standards', 'icon' => 'badge-check'],
    ];

    public function selectSop($id)
    {
        $this->activeSopId = $id;
    }

    public function getActiveSopProperty()
    {
        // For now, returning mock data based on ID
        // In real app, this would be a database query
        return [
            'id' => 2,
            'title' => 'SOP Deep Cleaning Rumah',
            'last_updated' => '12 Jan 2024',
            'version' => 'V1.2',
            'tujuan' => 'Memberikan standar prosedur pembersihan mendalam untuk rumah tinggal yang mencakup semua area utama, memastikan kebersihan maksimal dan kepuasan pelanggan. SOP ini bertujuan untuk menjaga konsistensi kualitas layanan dan efisiensi waktu kerja.',
            'ruang_lingkup' => [
                'Area kamar (kamar tidur, ruang tamu, ruang keluarga)',
                'Area dapur (kompor, kitchen set, sink, lantai)',
                'Area kamar mandi (toilet, shower, wastafel, cermin)',
                'Area tambahan sesuai permintaan customer'
            ],
            'langkah_kerja' => [
                [
                    'title' => 'Persiapan Alat dan Bahan',
                    'desc' => 'Cek kelengkapan: wet/dry vacuum cleaner, mop, kain lap, sikat, dan bahan pembersih (deterjen, pembersih lantai, cairan kaca). Pastikan semua dalam kondisi baik dan siap pakai.'
                ],
                [
                    'title' => 'Briefing Singkat dengan Customer',
                    'desc' => 'Konfirmasi area yang akan dibersihkan, tanyakan area prioritas atau area yang perlu perhatian khusus. Catat instruksi tambahan dari customer.'
                ],
                [
                    'title' => 'Proses Pembersihan Per Area',
                    'desc' => 'Mulai dari atas ke bawah: plafon/langit-langit → dinding → furniture → lantai. Gunakan teknik yang sesuai untuk setiap jenis permukaan.'
                ],
                [
                    'title' => 'Quality Check Sebelum Selesai',
                    'desc' => 'Periksa ulang semua area yang sudah dibersihkan. Pastikan tidak ada spot yang tertinggal. Laporkan ke customer dan minta approval sebelum meninggalkan lokasi.'
                ]
            ],
            'safety' => [
                'Gunakan sarung tangan saat menangani bahan kimia pembersih untuk melindungi kulit tangan dari iritasi.',
                'Hindari mencampur bahan kimia yang berbeda. Campuran bahan kimia dapat menghasilkan gas beracun yang berbahaya.',
                'Gunakan masker di area tertutup untuk menghindari menghirup debu atau uap pembersih yang berlebihan.',
                'Pastikan ventilasi baik saat menggunakan cairan pembersih berbau menyengat.'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.worker.sop.index', [
            'activeSop' => $this->activeSop
        ]);
    }
}
