<?php

namespace App\Livewire\SuperAdmin\Setting;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin-layout')]
class Index extends Component
{
    public $activeTab = 'umum';
    protected $queryString = ['activeTab'];

    // Properti Form
    public $platformName, $platformTagline, $timezone, $currency, $openingTime, $closingTime, $isMaintenance;
    public $commissionRate, $minimumFee;
    public $activePayments = [];
    public $smtpHost, $smtpPort, $fromEmail, $fromName;
    public $enableRegistration, $requireEmailVerification, $enableReviews;

    // Menarik data dari database saat halaman dimuat
    public function mount()
    {
        // Ambil semua setting dan ubah menjadi format array: ['key' => 'value']
        $settings = Setting::pluck('value', 'key')->toArray();

        // UMUM (Gunakan nilai default jika di database masih kosong)
        $this->platformName = $settings['platformName'] ?? 'UMKM Connect';
        $this->platformTagline = $settings['platformTagline'] ?? 'Connecting customers with local services';
        $this->timezone = $settings['timezone'] ?? 'Asia/Makassar'; 
        $this->currency = $settings['currency'] ?? 'IDR';
        $this->openingTime = $settings['openingTime'] ?? '08:00';
        $this->closingTime = $settings['closingTime'] ?? '18:00';
        
        // Konversi string ke boolean untuk toggle switch
        $this->isMaintenance = filter_var($settings['isMaintenance'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // KOMISI
        $this->commissionRate = $settings['commissionRate'] ?? 10.0;
        $this->minimumFee = $settings['minimumFee'] ?? 5000;

        // PAYMENT (Decode dari JSON string kembali ke Array)
        $defaultPayments = json_encode(['bank' => true, 'ewallet' => true, 'cash' => true]);
        $this->activePayments = json_decode($settings['activePayments'] ?? $defaultPayments, true);

        // EMAIL
        $this->smtpHost = $settings['smtpHost'] ?? 'smtp.gmail.com';
        $this->smtpPort = $settings['smtpPort'] ?? '587';
        $this->fromEmail = $settings['fromEmail'] ?? 'noreply@umkmconnect.id';
        $this->fromName = $settings['fromName'] ?? 'UMKM Connect Support';

        // LAINNYA
        $this->enableRegistration = filter_var($settings['enableRegistration'] ?? true, FILTER_VALIDATE_BOOLEAN);
        $this->requireEmailVerification = filter_var($settings['requireEmailVerification'] ?? true, FILTER_VALIDATE_BOOLEAN);
        $this->enableReviews = filter_var($settings['enableReviews'] ?? true, FILTER_VALIDATE_BOOLEAN);
    }

    // Menyimpan data ke database saat tombol Save diklik
    public function saveSettings()
    {
        // 1. Kumpulkan semua data form ke dalam array
        $dataToSave = [
            'platformName' => $this->platformName,
            'platformTagline' => $this->platformTagline,
            'timezone' => $this->timezone,
            'currency' => $this->currency,
            'openingTime' => $this->openingTime,
            'closingTime' => $this->closingTime,
            'isMaintenance' => $this->isMaintenance ? 'true' : 'false', // Simpan boolean sebagai string
            
            'commissionRate' => $this->commissionRate,
            'minimumFee' => $this->minimumFee,
            
            'activePayments' => json_encode($this->activePayments), // Array harus diubah jadi JSON string
            
            'smtpHost' => $this->smtpHost,
            'smtpPort' => $this->smtpPort,
            'fromEmail' => $this->fromEmail,
            'fromName' => $this->fromName,
            
            'enableRegistration' => $this->enableRegistration ? 'true' : 'false',
            'requireEmailVerification' => $this->requireEmailVerification ? 'true' : 'false',
            'enableReviews' => $this->enableReviews ? 'true' : 'false',
        ];

        // 2. Looping dan simpan (Update jika key sudah ada, Create jika belum ada)
        foreach ($dataToSave as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        
        session()->flash('message', 'Pengaturan platform berhasil diperbarui dan disimpan ke database!');
    }

    public function render()
    {
        return view('livewire.super-admin.setting.index');
    }
}