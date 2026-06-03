<?php

namespace App\Livewire\Worker\Sop;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.worker-layout')]
class Index extends Component
{
    public $search = '';
    public $activeSopId = 1; // Default to SOP Umum

    public $sops = [
        ['id' => 1, 'title' => 'SOP Umum', 'icon' => 'document-text'],
        ['id' => 2, 'title' => 'SOP Deep Cleaning', 'icon' => 'sparkles'],
        ['id' => 3, 'title' => 'SOP Office Cleaning', 'icon' => 'document-text'],
        ['id' => 4, 'title' => 'SOP Sofa & Carpet', 'icon' => 'sparkles'],
        ['id' => 5, 'title' => 'Safety Guidelines', 'icon' => 'document-text'],
        ['id' => 6, 'title' => 'Quality Standards', 'icon' => 'sparkles'],
    ];

    public function selectSop($id)
    {
        $this->activeSopId = $id;
    }

    public function getActiveSopProperty()
    {
        $allData = [
            1 => [
                'title' => 'SOP Umum Perilaku Staff',
                'last_updated' => '01 Jan 2024',
                'version' => 'V2.0',
                'tujuan' => 'Menjaga profesionalisme dan integritas seluruh staff saat bertugas di lokasi UMKM maupun pelanggan.',
                'ruang_lingkup' => ['Kedisiplinan waktu', 'Cara berkomunikasi', 'Penggunaan seragam', 'Etika bekerja'],
                'langkah_kerja' => [
                    ['title' => 'Persiapan Diri', 'desc' => 'Pastikan seragam rapi, bersih, dan menggunakan ID Card yang berlaku.'],
                    ['title' => 'Tiba di Lokasi', 'desc' => 'Hadir 15 menit sebelum jadwal mulai. Lakukan absen masuk di aplikasi.'],
                    ['title' => 'Sapa & Senyum', 'desc' => 'Gunakan bahasa yang sopan dan ramah saat bertemu customer atau rekan kerja.'],
                ],
                'safety' => ['Jaga kerahasiaan data customer', 'Laporkan jika ada kendala di lapangan segera.']
            ],
            2 => [
                'title' => 'SOP Deep Cleaning Rumah',
                'last_updated' => '12 Jan 2024',
                'version' => 'V1.2',
                'tujuan' => 'Memberikan standar prosedur pembersihan mendalam untuk rumah tinggal yang mencakup semua area utama.',
                'ruang_lingkup' => ['Area kamar tidur', 'Area dapur', 'Kamar mandi', 'Ruang tamu'],
                'langkah_kerja' => [
                    ['title' => 'Cek Alat', 'desc' => 'Pastikan vacuum, mop, dan pembersih kimia sudah lengkap.'],
                    ['title' => 'Cleaning Atas ke Bawah', 'desc' => 'Mulai dari plafon, lalu dinding, furniture, dan terakhir lantai.'],
                    ['title' => 'Detailing', 'desc' => 'Pastikan sela-sela kecil dan sudut ruangan tidak berdebu.'],
                ],
                'safety' => ['Gunakan sarung tangan', 'Hindari mencampur bahan kimia berbeda.']
            ],
            3 => [
                'title' => 'SOP Office Cleaning',
                'last_updated' => '15 Jan 2024',
                'version' => 'V1.0',
                'tujuan' => 'Menstandarisasi pembersihan area perkantoran agar tetap kondusif untuk bekerja.',
                'ruang_lingkup' => ['Meja kerja', 'Ruang meeting', 'Pantry kantor', 'Area lobby'],
                'langkah_kerja' => [
                    ['title' => 'Pembersihan Meja', 'desc' => 'Bersihkan debu tanpa menggeser dokumen penting milik customer.'],
                    ['title' => 'Sanitasi Gadget', 'desc' => 'Bersihkan keyboard, mouse, dan telepon dengan alkohol 70%.'],
                    ['title' => 'Pengosongan Sampah', 'desc' => 'Ganti kantong plastik sampah setiap pagi dan sore hari.'],
                ],
                'safety' => ['Hati-hati dengan kabel listrik', 'Gunakan tanda "Lantai Basah" saat mengepel lobby.']
            ],
            4 => [
                'title' => 'SOP Sofa & Carpet Cleaning',
                'last_updated' => '20 Jan 2024',
                'version' => 'V1.1',
                'tujuan' => 'Membersihkan noda membandel dan tungau pada permukaan kain sofa dan karpet.',
                'ruang_lingkup' => ['Sofa kain/leather', 'Karpet kantor/rumah', 'Kasur / Springbed'],
                'langkah_kerja' => [
                    ['title' => 'Vakum Kering', 'desc' => 'Angkat semua debu dan kotoran kasar sebelum proses pencucian.'],
                    ['title' => 'Spotting', 'desc' => 'Berikan cairan khusus pada noda yang membandel (kopi, tinta, dll).'],
                    ['title' => 'Extraction', 'desc' => 'Lakukan pencucian dan penyedotan air kotor hingga maksimal.'],
                ],
                'safety' => ['Tes cairan di area tersembunyi dulu', 'Pastikan pengeringan sempurna untuk hindari bau apek.']
            ],
            5 => [
                'title' => 'Safety & Security Guidelines',
                'last_updated' => '05 Feb 2024',
                'version' => 'V3.0',
                'tujuan' => 'Memastikan keselamatan kerja staff dan keamanan aset pelanggan.',
                'ruang_lingkup' => ['Alat Pelindung Diri (APD)', 'Keamanan barang berharga', 'Prosedur darurat'],
                'langkah_kerja' => [
                    ['title' => 'Penggunaan APD', 'desc' => 'Gunakan masker dan sarung tangan sesuai standar jenis pekerjaan.'],
                    ['title' => 'Penanganan Barang Mewah', 'desc' => 'Dilarang menyentuh/memindah barang antik/mewah tanpa izin admin.'],
                    ['title' => 'Prosedur Kebakaran', 'desc' => 'Kenali letak APAR di setiap lokasi kerja UMKM.'],
                ],
                'safety' => ['Utamakan keselamatan jiwa di atas pekerjaan', 'Segera lapor jika ada kecelakaan kerja.']
            ],
            6 => [
                'title' => 'Quality Standards (QC)',
                'last_updated' => '10 Feb 2024',
                'version' => 'V1.5',
                'tujuan' => 'Menjaga agar hasil pekerjaan selalu memuaskan dan sesuai ekspektasi pelanggan.',
                'ruang_lingkup' => ['Checklist kebersihan', 'Dokumentasi foto', 'Serah terima tugas'],
                'langkah_kerja' => [
                    ['title' => 'Self Inspection', 'desc' => 'Cek kembali hasil kerja berdasarkan checklist standar UMKM.'],
                    ['title' => 'Dokumentasi Before/After', 'desc' => 'Ambil foto yang jelas sebagai bukti hasil pekerjaan.'],
                    ['title' => 'Konfirmasi Customer', 'desc' => 'Minta customer memeriksa hasil dan berikan feedback jika ada.'],
                ],
                'safety' => ['Pastikan semua peralatan dibawa pulang kembali', 'Kunci pintu/ruangan jika diinstruksikan.']
            ],
        ];

        return $allData[$this->activeSopId] ?? $allData[1];
    }

    public function render()
    {
        // Filter SOPs based on search
        $filteredSops = collect($this->sops)->filter(function($sop) {
            return empty($this->search) || 
                   str_contains(strtolower($sop['title']), strtolower($this->search));
        });

        return view('livewire.worker.sop.index', [
            'activeSop' => $this->activeSop,
            'sopsList' => $filteredSops
        ]);
    }
}
