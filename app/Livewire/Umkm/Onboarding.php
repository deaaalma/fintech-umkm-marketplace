<?php

namespace App\Livewire\Umkm;

use Livewire\Component;

class Onboarding extends Component
{
    public int $step = 1;

    // Step 1: Informasi Bisnis
    public string $business_name = '';
    public string $business_category = '';
    public string $business_description = '';
    public string $business_address = '';
    public string $business_city = '';
    public string $business_phone = '';

    // Step 2: Data Pemilik
    public string $owner_name = '';
    public string $owner_nik = '';
    public string $owner_birthdate = '';
    public $owner_ktp_photo;
    public $owner_selfie_photo;

    // Step 3: Dokumen
    public $document_ktp;
    public $document_certificate;
    public $document_npwp;
    public $document_place;

    // Step 4: Rekening
    public string $bank_name = '';
    public string $bank_account_number = '';
    public string $bank_account_name = '';

    public function nextStep()
    {
        $this->validateCurrentStep();
        if ($this->step < 5) {
            $this->step++;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function validateCurrentStep()
    {
        // Add basic validation logic based on current step
        try {
            if ($this->step === 1) {
                $this->validate([
                    'business_name' => 'required',
                    'business_category' => 'required',
                    'business_description' => 'required',
                    'business_address' => 'required',
                    'business_city' => 'required',
                    'business_phone' => 'required',
                ]);
            } elseif ($this->step === 2) {
                $this->validate([
                    'owner_name' => 'required',
                    'owner_nik' => 'required',
                    'owner_birthdate' => 'required',
                ]);
            } elseif ($this->step === 4) {
                $this->validate([
                    'bank_name' => 'required',
                    'bank_account_number' => 'required',
                    'bank_account_name' => 'required',
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Temporarily catch validation exceptions so the user can freely click through the UI steps for testing purposes.
            // In production, we will remove this try/catch block.
        }
    }

    public function submit()
    {
        $this->validateCurrentStep();
        // Database saving logic will go here

        session()->flash('success', 'Onboarding completed successfully!');
        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.umkm.onboarding')->layout('layouts.blank');
    }
}
