<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
    #[Layout('layouts.blank')]
    class extends Component {
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $user = auth()->user();
        $role = $user->role;

        // Tentukan URL berdasarkan role & kondisi data
        $redirectUrl = match ($role) {
            'superadmin' => route('superadmin.dashboard', absolute: false),
            
            'admin_umkm' => $user->umkm()->exists() 
                ? route('umkm.dashboard', absolute: false) 
                : route('umkm.setup', absolute: false), // Paksa setup jika belum ada data
                
            'worker'     => route('worker.dashboard', absolute: false),
            'customer'   => route('customer.dashboard', absolute: false),
            default      => route('dashboard', absolute: false),
        };

        $this->redirectIntended(default: $redirectUrl, navigate: true);
    }
}; ?>



<div class="flex w-full bg-[#f8fafc] font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
        
        .font-figtree { font-family: 'Figtree', sans-serif; }
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .brand-gradient {
            background: linear-gradient(135deg, #000B44 0%, #004E89 100%);
        }
        
        .input-focus:focus {
            border-color: #0077B6 !important;
            box-shadow: 0 0 0 4px rgba(0, 119, 182, 0.1) !important;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-btn-apple:hover { background-color: #1a1a1a; }
        .social-btn-apple:hover svg { color: #ffffff; }

        .social-btn-facebook:hover { background-color: #1877F2; border-color: #1877F2; }
        .social-btn-facebook:hover svg { color: #ffffff; }
    </style>

    <!-- Left Column: Sticky -->
    <div class="hidden lg:flex w-1/2 flex-col justify-between p-16 text-white relative overflow-hidden brand-gradient sticky top-0 h-screen flex-shrink-0">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20" 
             style="background-image: url('{{ asset('storage/images/auth.jpg') }}'); background-size: cover; background-position: center; mix-blend-mode: overlay;">
        </div>
        
        <!-- Subtle Glows -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#0077B6] rounded-full blur-[100px] opacity-20"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#0077B6] rounded-full blur-[100px] opacity-20"></div>

        <!-- Logo separate at top -->
        <div class="relative z-10">
            <a href="/"
                class="inline-flex items-center px-6 py-3 bg-white/10 glass-effect rounded-2xl font-plus font-bold text-lg tracking-tight hover:bg-white/20 transition-all duration-300"
                wire:navigate>
                <span class="text-white">JOS</span>
            </a>
        </div>

        <div class="flex flex-col items-start space-y-8 relative z-10">
            <h1 class="font-black" style="font-size: 80px; line-height: 0.9; font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.04em;">Welcome Back!</h1>
            <p style="font-size: 20px; line-height: 1.6; font-family: 'Inter', sans-serif; font-weight: 300; color: rgba(219,234,254,0.7); letter-spacing: 0.01em; max-width: 520px;">
                Login to continue accessing your account and enjoy our services from trusted UMKM partners.
            </p>
        </div>

        <div class="text-sm font-medium text-blue-200/50 relative z-10 font-plus tracking-wider">
            &copy; {{ date('Y') }} JOS
        </div>
    </div>

    <!-- Right Column: Scrollable -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16 bg-[#f8fafc] overflow-y-auto min-h-screen">
        <div class="w-full max-w-md">
            <!-- Mobile Logo -->
            <div class="lg:hidden mb-12">
                <span class="text-2xl font-plus font-black text-[#000B44]">JOS</span>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="mb-10">
                <h2 class="text-4xl font-black text-[#000B44] mb-3 font-plus tracking-tight">Login</h2>
                <p class="text-slate-500 font-medium">Enter your credentials to continue</p>
            </div>

            <form wire:submit="login" class="space-y-6" x-data="{ showPassword: false }">
                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Email or phone number</label>
                    <div class="relative group">
                        <input wire:model="form.email" type="email" id="email"
                            class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl font-medium text-[#000B44] transition-all duration-300 input-focus placeholder:text-slate-400"
                            placeholder="Email address" required autofocus autocomplete="username">
                    </div>
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-xs font-bold text-red-500" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label for="password" class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Password</label>
                    </div>
                    <div class="relative group">
                        <input wire:model="form.password" :type="showPassword ? 'text' : 'password'" id="password"
                            class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl font-medium text-[#000B44] transition-all duration-300 input-focus placeholder:text-slate-400"
                            placeholder="Enter your password" required autocomplete="current-password">

                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;">
                                <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.25 5.25l13.5 13.5" />
                                <path d="M9.88 9.88a3 3 0 104.24 4.24" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-xs font-bold text-red-500" />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label for="remember" class="flex items-center gap-3 cursor-pointer group">
                        <input wire:model="form.remember" id="remember" type="checkbox"
                            class="w-4 h-4 rounded border-slate-300 cursor-pointer"
                            style="accent-color: #0077B6;">
                        <span class="text-sm font-semibold text-slate-600 group-hover:text-[#000B44] transition-colors">Remember me</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-bold text-[#0077B6] hover:text-[#000B44] transition-colors"
                            wire:navigate>
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full bg-[#000B44] hover:bg-[#0077B6] text-white font-black font-plus py-4 rounded-2xl shadow-xl shadow-[#000B44]/10 hover:shadow-[#0077B6]/20 transition-all duration-300 transform hover:-translate-y-1 disabled:opacity-50 flex justify-center items-center gap-3"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Login</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>

                <div class="relative flex items-center justify-center py-4">
                    <div class="w-full border-t border-slate-100"></div>
                    <span class="absolute bg-[#f8fafc] px-4 text-xs font-bold text-slate-400 uppercase tracking-widest">or do it via other accounts</span>
                </div>

                <div class="flex justify-center gap-4 mt-2">
                    <a href="#" class="flex justify-center items-center w-14 h-14 bg-white border border-slate-100 rounded-2xl hover:bg-slate-50 transition-all duration-200 aspect-square">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                        </svg>
                    </a>

                    <a href="#" class="social-btn-apple flex justify-center items-center w-14 h-14 bg-white border border-slate-100 rounded-2xl transition-all duration-200 aspect-square">
                        <svg class="w-5 h-5 text-[#000B44] transition-colors duration-200" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.74 1.18 0 2.45-1.02 4.12-.55 2.1.56 3.2 2.68 3.73 3.44-3.32 1.6-2.74 5.95.6 7.28-.48 1.4-1.2 2.8-2.23 3.86l-.15.2zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z" />
                        </svg>
                    </a>

                    <a href="#" class="social-btn-facebook flex justify-center items-center w-14 h-14 bg-white border border-slate-100 rounded-2xl transition-all duration-200 aspect-square">
                        <svg class="w-5 h-5 text-[#1877F2] transition-colors duration-200" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                        </svg>
                    </a>
                </div>
            </form>

            <div class="mt-[52px] text-center">
                <p class="text-sm font-semibold text-slate-500">
                    Belum punya akun? <button @click.prevent="$dispatch('open-register-choice')"
                        class="text-[#0077B6] hover:text-[#000B44] transition-colors font-black border-b-2 border-[#0077B6]/20 hover:border-[#000B44] pb-1">Daftar Sekarang</button>
                </p>
            </div>
        </div>
    </div>
</div>
