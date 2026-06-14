<?php

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.blank')] 
class extends Component {
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public bool $terms = false;

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'terms' => ['accepted'],
        ]);

        // Secara otomatis set role ke admin_umkm
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin_umkm',
            'otp_code' => (string) rand(100000, 999999),
            'otp_expires_at' => now()->addMinutes(30),
        ]);

        event(new Registered($user));

        Mail::to($user->email)->send(new OtpMail($user->otp_code));

        Auth::login($user);

        // Arahkan ke halaman verifikasi OTP
        $this->redirect(route('verification.notice', absolute: false), navigate: true);
    }
}; ?>

<div class="flex w-full bg-[#f8fafc] font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');

        .font-figtree { font-family: 'Figtree', sans-serif; }
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }

        .brand-gradient-umkm {
            background: linear-gradient(135deg, #000B44 0%, #004E89 100%);
        }

        .input-focus-umkm:focus {
            border-color: #0077B6 !important;
            box-shadow: 0 0 0 4px rgba(0, 119, 182, 0.1) !important;
        }

        .glass-effect-umkm {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-btn-apple-umkm:hover { background-color: #1a1a1a; }
        .social-btn-apple-umkm:hover svg { color: #ffffff; }

        .social-btn-facebook-umkm:hover { background-color: #1877F2; border-color: #1877F2; }
        .social-btn-facebook-umkm:hover svg { color: #ffffff; }
    </style>

    {{-- Left Column: Sticky --}}
    <div class="hidden lg:flex w-1/2 flex-col justify-between p-16 text-white relative overflow-hidden brand-gradient-umkm sticky top-0 h-screen flex-shrink-0">
        <div class="absolute inset-0 opacity-20"
             style="background-image: url('{{ asset('storage/images/umkm-reg.jpg') }}'); background-size: cover; background-position: center; mix-blend-mode: overlay;">
        </div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#0077B6] rounded-full blur-[100px] opacity-20"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#0077B6] rounded-full blur-[100px] opacity-20"></div>

        <div class="relative z-10">
            <a href="/"
                class="inline-flex items-center px-6 py-3 bg-white/10 glass-effect-umkm rounded-2xl font-plus font-bold text-lg tracking-tight hover:bg-white/20 transition-all duration-300"
                wire:navigate>
                <span class="text-white">JOS</span>
            </a>
        </div>

        <div class="flex flex-col items-start space-y-8 relative z-10">
            <h1 class="font-black" style="font-size: 80px; line-height: 0.9; font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.04em;">Grow up!</h1>
            <p style="font-size: 20px; line-height: 1.6; font-family: 'Inter', sans-serif; font-weight: 300; color: rgba(219,234,254,0.7); letter-spacing: 0.01em; max-width: 520px;">
                Bergabunglah dengan ribuan pengusaha lainnya dan mulai digitalisasi usaha Anda hari ini.
            </p>
            
            <div class="flex gap-4 items-center mt-4">
                <div class="flex -space-x-3">
                    <div class="w-12 h-12 rounded-full border-2 border-[#000B44] bg-slate-200"></div>
                    <div class="w-12 h-12 rounded-full border-2 border-[#000B44] bg-slate-300"></div>
                    <div class="w-12 h-12 rounded-full border-2 border-[#000B44] bg-slate-400"></div>
                </div>
                <p class="text-sm font-medium italic text-blue-200/70 tracking-wide font-plus">+500 Owners joined this week</p>
            </div>
        </div>

        <div class="text-sm font-medium text-blue-200/50 relative z-10 font-plus tracking-wider">
            &copy; {{ date('Y') }} JOS Partner Center
        </div>
    </div>

    {{-- Right Column: Scrollable --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16 bg-[#f8fafc] overflow-y-auto min-h-screen">
        <div class="w-full max-w-md py-8">

            {{-- Mobile Logo --}}
            <div class="lg:hidden mb-10">
                <span class="text-2xl font-plus font-black text-[#000B44]">JOS</span>
            </div>

            <div class="mb-8">
                <h2 class="text-4xl font-black text-[#000B44] mb-3 font-plus tracking-tight">Partner Registration</h2>
                <p class="text-slate-500 font-medium">Start your journey as a business owner</p>
            </div>

            <form wire:submit="register" class="space-y-5" x-data="{ showPassword: false }">

                {{-- Full Name --}}
                <div class="space-y-2">
                    <label for="name" class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Business owner name</label>
                    <input wire:model="name" type="text" id="name"
                        class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl font-medium text-[#000B44] transition-all duration-300 input-focus-umkm placeholder:text-slate-400"
                        placeholder="Enter your name" required autofocus>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs font-bold text-red-500" />
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label for="email" class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Business e-mail</label>
                    <input wire:model="email" type="email" id="email"
                        class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl font-medium text-[#000B44] transition-all duration-300 input-focus-umkm placeholder:text-slate-400"
                        placeholder="email@company.com" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-red-500" />
                </div>

                {{-- Phone --}}
                <div class="space-y-2">
                    <label for="phone" class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">WhatsApp number</label>
                    <input wire:model="phone" type="text" id="phone"
                        class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl font-medium text-[#000B44] transition-all duration-300 input-focus-umkm placeholder:text-slate-400"
                        placeholder="0812..." required>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-xs font-bold text-red-500" />
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label for="password" class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Password</label>
                    <div class="relative">
                        <input wire:model="password" :type="showPassword ? 'text' : 'password'" id="password"
                            class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl font-medium text-[#000B44] transition-all duration-300 input-focus-umkm placeholder:text-slate-400"
                            placeholder="Create password" required>
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
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-red-500" />
                </div>

                {{-- Terms --}}
                <div class="flex items-start gap-3 pt-1">
                    <input wire:model="terms" id="terms" type="checkbox"
                        class="w-4 h-4 mt-0.5 rounded border-slate-300 cursor-pointer flex-shrink-0"
                        style="accent-color: #0077B6;">
                    <label for="terms" class="text-sm text-slate-500 leading-relaxed cursor-pointer">
                        I agree to the <a href="#" class="font-bold text-[#000B44] hover:text-[#0077B6] transition-colors">Partner Terms</a> and <a href="#" class="font-bold text-[#000B44] hover:text-[#0077B6] transition-colors">Service Agreement</a>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('terms')" class="text-xs font-bold text-red-500" />

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full bg-[#000B44] hover:bg-[#0077B6] text-white font-black font-plus py-4 rounded-2xl shadow-xl shadow-[#000B44]/10 hover:shadow-[#0077B6]/20 transition-all duration-300 transform hover:-translate-y-1 disabled:opacity-50 flex justify-center items-center gap-3"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Create Merchant Account</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>

            </form>

            <div class="mt-[52px] text-center space-y-3">
                <p class="text-sm font-semibold text-slate-500">
                    Not a business owner? <a href="{{ route('register') }}"
                        class="text-[#0077B6] hover:text-[#000B44] transition-colors font-black border-b-2 border-[#0077B6]/20 hover:border-[#000B44] pb-1" wire:navigate>Register as Customer</a>
                </p>
            </div>
        </div>
    </div>
</div>