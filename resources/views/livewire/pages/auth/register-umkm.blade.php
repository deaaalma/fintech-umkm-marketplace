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
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        event(new Registered($user));

        Mail::to($user->email)->send(new OtpMail($user->otp_code));

        Auth::login($user);

        // Arahkan ke halaman verifikasi OTP
        $this->redirect(route('verification.notice', absolute: false), navigate: true);
    }
}; ?>

<div class="flex min-h-screen w-full bg-white">
    <div class="hidden lg:flex w-1/2 bg-indigo-900 flex-col justify-between p-10 text-white relative"
        style="background-image: linear-gradient(rgba(30, 27, 75, 0.8), rgba(30, 27, 75, 0.8)), url('{{ asset('storage/images/umkm-reg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="flex flex-col gap-32">
            <div class="relative z-10">
                <a href="/" class="inline-flex items-center px-4 py-2 bg-white text-gray-800 rounded-full font-bold text-lg shadow-md" wire:navigate>
                    UMKM System <span class="ml-2 text-indigo-600 text-sm">Partner</span>
                </a>
            </div>

            <div class="flex flex-col items-start space-y-6 relative z-10">
                <h1 class="text-4xl font-bold italic">Grow your business with us.</h1>
                <p class="text-indigo-100 text-lg max-w-md">
                    Bergabunglah dengan ribuan pengusaha lainnya dan mulai digitalisasi usaha Anda hari ini.
                </p>
                
                <div class="flex gap-4 items-center mt-10">
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full border-2 border-indigo-900 bg-gray-300"></div>
                        <div class="w-10 h-10 rounded-full border-2 border-indigo-900 bg-gray-400"></div>
                        <div class="w-10 h-10 rounded-full border-2 border-indigo-900 bg-gray-500"></div>
                    </div>
                    <p class="text-sm font-medium italic">+500 Owners joined this week</p>
                </div>
            </div>
        </div>

        <div class="text-sm text-indigo-300 relative z-10 italic">
            &copy; {{ date('Y') }} UMKM System Partner Center.
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
        <div class="w-full max-w-md py-8">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Partner Registration</h2>
                <p class="text-gray-500">Start your journey as a business owner</p>
            </div>

            <form wire:submit="register" class="space-y-5" x-data="{ showPassword: false }">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-600">Full name</label>
                    <input wire:model="name" type="text" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-3 placeholder-gray-400"
                        placeholder="Your full name" required autofocus>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Business E-mail</label>
                    <input wire:model="email" type="email" id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-3 placeholder-gray-400"
                        placeholder="email@company.com" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-600">WhatsApp Number</label>
                    <input wire:model="phone" type="text" id="phone"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-3 placeholder-gray-400"
                        placeholder="0812..." required>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Password</label>
                    <div class="relative">
                        <input wire:model="password" :type="showPassword ? 'text' : 'password'" id="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-600 focus:border-indigo-600 block w-full p-3 pr-10 placeholder-gray-400"
                            placeholder="Create password" required>

                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.25 5.25l13.5 13.5" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88a3 3 0 104.24 4.24" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-start py-2">
                    <div class="flex items-center h-5">
                        <input wire:model="terms" id="terms" type="checkbox"
                            class="w-5 h-5 border border-gray-300 rounded bg-gray-50 text-indigo-600 focus:ring-3 focus:ring-indigo-600">
                    </div>
                    <label for="terms" class="ml-3 text-sm text-gray-500">
                        I agree to the <a href="#" class="font-bold text-gray-900 hover:underline">Partner Terms</a> and <a href="#" class="font-bold text-gray-900 hover:underline">Service Agreement</a>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('terms')" class="mt-0" />

                <button type="submit"
                    class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-bold rounded-lg text-sm px-5 py-3 text-center transition-all disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Create Merchant Account</span>
                    <span wire:loading>Processing...</span>
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-500 italic">
                    Not a business owner? <a href="{{ route('register') }}" class="font-bold text-gray-900 hover:underline" wire:navigate>Register as Customer</a>
                </p>
            </div>
        </div>
    </div>
</div>