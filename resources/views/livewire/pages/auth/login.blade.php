<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new 
#[Layout('layouts.blank')] 
class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // 👇 LOGIKA REDIRECT BERDASARKAN ROLE 👇
        
        $role = auth()->user()->role; 

        // Tentukan mau kemana berdasarkan role
        $redirectUrl = match ($role) {
            'superadmin' => route('admin.dashboard', absolute: false),
            'admin_umkm'  => route('umkm.dashboard', absolute: false),
            'worker'      => route('worker.dashboard', absolute: false),
            'customer'      => route('customer.dashboard', absolute: false),
            default       => route('dashboard', absolute: false), // customer lari kesini
        };

        // RedirectIntended artinya: 
        // Kalau user tadi mau buka halaman Admin tapi dihadang login, balikin ke Admin.
        // Tapi kalau login biasa, arahkan ke $redirectUrl yang kita set diatas.
        $this->redirectIntended(default: $redirectUrl, navigate: true);
    }
}; ?>



    <div class="flex min-h-screen w-full">
        
        <div class="hidden lg:flex w-1/2 bg-gray-600 flex-col justify-between p-12 text-white relative overflow-hidden" 
             style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('storage/images/auth.jpg') }}'); background-size: cover; background-position: center;">
            
            <div class="relative z-10">
                <a href="/" class="inline-flex items-center px-6 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-full font-bold text-lg shadow-lg hover:bg-white/20 transition-all duration-300" style="font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.02em;" wire:navigate>
                    JOS
                </a>
            </div>

            <div class="flex flex-col items-start space-y-6 relative z-10">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Welcome Back!</h1>
                <p class="text-[#C5EBF4] text-lg max-w-md font-medium leading-relaxed" style="font-family: 'Figtree', sans-serif;">
                    Masuk ke akun Anda untuk mengelola toko UMKM Anda atau nikmati layanan dari mitra terpercaya kami.
                </p>
            </div>

            <div class="text-sm text-gray-400 relative z-10">
                &copy; {{ date('Y') }} JOS Platform.
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col justify-center px-6 py-10 sm:p-12 lg:p-16 bg-white min-h-screen lg:min-h-0 relative">
            
            <!-- Mobile Header Logo -->
            <div class="lg:hidden absolute top-6 left-6 right-6 flex items-center justify-between">
                <a href="/" class="inline-flex items-center text-2xl font-black text-[#000066] tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;" wire:navigate>
                    JOS<span class="text-[#0072BB]">.</span>
                </a>
            </div>

            <div class="w-full max-w-md mx-auto mt-12 lg:mt-0">
                
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <h2 class="text-3xl lg:text-4xl font-extrabold text-[#000066] mb-2 tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Masuk</h2>
                <p class="text-[#000066]/60 mb-8 text-base font-medium" style="font-family: 'Figtree', sans-serif;">Masukkan email dan password Anda</p>

                <form wire:submit="login" class="space-y-6" x-data="{ showPassword: false }">
                    
                    <div>
                        <label for="email" class="block mb-2 text-sm font-semibold text-[#000066]" style="font-family: 'Figtree', sans-serif;">Email</label>
                        <input wire:model="form.email" type="email" id="email" 
                            class="bg-[#F8FAFC] border border-[#000066]/10 text-[#000066] text-base lg:text-sm rounded-xl focus:ring-[#0072BB]/50 focus:border-[#0072BB] block w-full p-4 lg:p-3.5 placeholder-[#000066]/40 transition-colors shadow-sm" 
                            placeholder="Alamat email Anda" required autofocus autocomplete="username" style="font-family: 'Figtree', sans-serif;">
                        
                        <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm font-semibold text-[#000066]" style="font-family: 'Figtree', sans-serif;">Password</label>
                        <div class="relative">
                            <input wire:model="form.password" :type="showPassword ? 'text' : 'password'" id="password" 
                                class="bg-[#F8FAFC] border border-[#000066]/10 text-[#000066] text-base lg:text-sm rounded-xl focus:ring-[#0072BB]/50 focus:border-[#0072BB] block w-full p-4 lg:p-3.5 pr-12 placeholder-[#000066]/40 transition-colors shadow-sm" 
                                placeholder="Masukkan password Anda" required autocomplete="current-password" style="font-family: 'Figtree', sans-serif;">
                            
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#000066]/40 hover:text-[#0072BB] transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.25 5.25l13.5 13.5"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88a3 3 0 104.24 4.24"/></svg>
                            </button>
                        </div>
                        
                        <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-6">
                                <input wire:model="form.remember" id="remember" type="checkbox" class="w-5 h-5 lg:w-4 lg:h-4 border border-[#000066]/20 rounded md:rounded-md bg-[#F8FAFC] text-[#0072BB] focus:ring-[#0072BB]/30">
                            </div>
                            <div class="ml-3 text-sm flex items-center mt-[2px] lg:mt-0">
                                <label for="remember" class="text-[#000066]/70 font-medium" style="font-family: 'Figtree', sans-serif;">Ingat saya</label>
                            </div>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#0072BB] hover:text-[#000066] transition-colors mt-[2px] lg:mt-0" style="font-family: 'Figtree', sans-serif;" wire:navigate>
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full text-white bg-[#000066] hover:bg-[#000066]/90 focus:ring-4 focus:outline-none focus:ring-[#000066]/30 font-bold rounded-xl text-base lg:text-sm px-5 py-4 lg:py-4 text-center disabled:opacity-50 transition-all duration-300 shadow-lg shadow-[#000066]/20 active:scale-[0.98]" style="font-family: 'Plus Jakarta Sans', sans-serif;" wire:loading.attr="disabled">
                        <span wire:loading.remove>Masuk Sekarang</span>
                        <span wire:loading>Memproses...</span>
                    </button>

                    <div class="relative flex items-center justify-center my-6">
                        <div class="w-full border-t border-[#000066]/10"></div>
                        <span class="absolute bg-white px-3 text-[#000066]/50 text-sm font-medium" style="font-family: 'Figtree', sans-serif;">atau masuk dengan</span>
                    </div>

                   <div class="flex justify-center space-x-4">
                        <a href="#" class="p-3.5 rounded-xl border border-[#000066]/10 bg-[#F8FAFC] hover:bg-white hover:border-[#0072BB] hover:shadow-md transition-all duration-300 group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" /><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" /><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" /><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" /></svg>
                        </a>
                        <a href="#" class="p-3.5 rounded-xl border border-[#000066]/10 bg-[#F8FAFC] hover:bg-[#1877F2] hover:border-[#1877F2] hover:shadow-md hover:text-white text-[#1877F2] transition-all duration-300 group">
                            <svg class="w-5 h-5 fill-current group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24"><path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z"/></svg>
                        </a>
                        <a href="#" class="p-3.5 rounded-xl border border-[#000066]/10 bg-[#F8FAFC] hover:bg-black hover:border-black hover:shadow-md hover:text-white text-black transition-all duration-300 group">
                            <svg class="w-5 h-5 fill-current group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    </div>

                    <p class="text-base font-medium text-center text-[#000066]/70 mt-4" style="font-family: 'Figtree', sans-serif;">
                        Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-[#0072BB] hover:text-[#000066] transition-colors hover:underline" wire:navigate>Daftar sekarang</a>
                    </p>
                </form>
            </div>
        </div>
    </div>