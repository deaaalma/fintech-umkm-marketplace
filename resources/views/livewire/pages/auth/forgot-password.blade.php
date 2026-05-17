<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new 
#[Layout('layouts.blank')] 
class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>



    <div class="min-h-screen flex flex-col justify-center bg-white lg:bg-[#F8FAFC] px-6 py-10 sm:p-12 relative">
        
        <div class="w-full max-w-md mx-auto bg-white lg:rounded-[2rem] lg:shadow-xl lg:p-10 space-y-6">
            
            <div class="flex items-center justify-center lg:hidden mb-6">
                <a href="/" class="inline-flex items-center text-2xl font-black text-[#000066] tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;" wire:navigate>
                    JOS<span class="text-[#0072BB]">.</span>
                </a>
            </div>

            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-[#000066] tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Lupa Password?</h1>
                <p class="mt-3 text-base font-medium text-[#000066]/60 text-center leading-relaxed" style="font-family: 'Figtree', sans-serif;">
                    Masukkan email Anda dan kami akan mengirimkan link untuk mereset kata sandi Anda.
                </p>
            </div>

            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form wire:submit="sendPasswordResetLink" class="space-y-6">
                
                <div>
                    <label for="email" class="block mb-2 text-sm font-semibold text-[#000066]" style="font-family: 'Figtree', sans-serif;">Email</label>
                    <input wire:model="email" id="email" type="email" name="email" 
                        class="bg-[#F8FAFC] border border-[#000066]/10 text-[#000066] text-base lg:text-sm rounded-xl focus:ring-[#0072BB]/50 focus:border-[#0072BB] block w-full p-4 lg:p-3.5 placeholder-[#000066]/40 transition-colors shadow-sm" 
                        placeholder="Ketik alamat email Anda yang terdaftar" required autofocus style="font-family: 'Figtree', sans-serif;">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <button type="submit" class="w-full text-white bg-[#000066] hover:bg-[#000066]/90 focus:ring-4 focus:outline-none focus:ring-[#000066]/30 font-bold rounded-xl text-base lg:text-sm px-5 py-4 lg:py-4 text-center disabled:opacity-50 transition-all duration-300 shadow-lg shadow-[#000066]/20 active:scale-[0.98]" style="font-family: 'Plus Jakarta Sans', sans-serif;" wire:loading.attr="disabled">
                    <span wire:loading.remove>Kirim Link Reset</span>
                    <span wire:loading>Mengirim...</span>
                </button>

            </form>

            <div class="flex items-center justify-center mt-6">
                <a href="{{ route('login') }}" class="flex items-center text-base font-semibold text-[#0072BB] hover:text-[#000066] transition-colors mt-2" style="font-family: 'Figtree', sans-serif;" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke halaman Masuk
                </a>
            </div>

        </div>
    </div>
