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

new
    #[Layout('layouts.blank')]
    class extends Component {
    public string $name = '';
    public string $email = '';
    public string $phone = ''; // Tambahan field phone
    public string $password = '';
    public bool $terms = false; // Tambahan field terms

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:20'], // Validasi phone
            // Hapus 'confirmed' karena di desain cuma 1 input password
            'password' => ['required', 'string', Rules\Password::defaults()],
            'terms' => ['accepted'], // Wajib dicentang
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Generate a 6 digit OTP
        $otpCode = (string) rand(100000, 999999);

        $validated['otp_code'] = $otpCode;
        $validated['otp_expires_at'] = now()->addMinutes(10);

        $user = User::create($validated);

        event(new Registered($user));

        // Send OTP email
        Mail::to($user->email)->send(new OtpMail($otpCode));

        Auth::login($user);

        $this->redirect(route('verification.notice', absolute: false), navigate: true);
    }
}; ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - UMKM System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white">

    <div class="flex min-h-screen w-full">

        <div class="hidden lg:flex w-1/2 bg-gray-600 flex-col justify-between p-10 text-white relative"
            style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('storage/images/auth.jpg') }}'); background-size: cover; background-position: center;">
            <div class="flex flex-col gap-32">
                <div class="relative z-10">
                    <a href="/"
                        class="inline-flex items-center px-4 py-2 bg-white text-gray-800 rounded-full font-bold text-lg shadow-md"
                        wire:navigate>
                        UMKM System
                    </a>
                </div>

                <div class="flex flex-col items-start space-y-6 relative z-10">
                    <h1 class="text-4xl font-bold">Welcome!</h1>
                    <p class="text-gray-200 text-lg max-w-md">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vulputate ut laoreet velit ma.
                    </p>
                </div>
            </div>

            <div class="text-sm text-gray-400 relative z-10">
                &copy; {{ date('Y') }} UMKM System.
            </div>
        </div>


        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
            <div class="w-full max-w-md py-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Create your account</h2>
                <p class="text-gray-500 mb-8">It's free and easy</p>

                <form wire:submit="register" class="space-y-5" x-data="{ showPassword: false }">

                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-600">Full name</label>
                        <input wire:model="name" type="text" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-3 placeholder-gray-400"
                            placeholder="Enter your name" required autofocus>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-600">E-mail</label>
                        <input wire:model="email" type="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-3 placeholder-gray-400"
                            placeholder="Type your e-mail" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-600">Phone number</label>
                        <input wire:model="phone" type="text" id="phone"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-3 placeholder-gray-400"
                            placeholder="Type your phone number" required>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Password</label>
                        <div class="relative">
                            <input wire:model="password" :type="showPassword ? 'text' : 'password'" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-3 pr-10 placeholder-gray-400"
                                placeholder="Type your password" required>

                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.25 5.25l13.5 13.5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.88 9.88a3 3 0 104.24 4.24" />
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Must be 8 characters at least</p>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input wire:model="terms" id="terms" type="checkbox"
                                class="w-5 h-5 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-black">
                        </div>
                        <label for="terms" class="ml-3 text-sm text-gray-500">
                            By creating an account means you agree to the <a href="#"
                                class="font-bold text-gray-900 hover:underline">Terms and Conditions</a>, and our <a
                                href="#" class="font-bold text-gray-900 hover:underline">Privacy Policy</a>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('terms')" class="mt-0" />

                    <button type="submit"
                        class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Sign Up</span>
                        <span wire:loading>Loading...</span>
                    </button>

                    <div class="relative flex items-center justify-center my-6">
                        <div class="w-full border-t border-gray-200"></div>
                        <span class="absolute bg-white px-3 text-gray-400 text-xs uppercase">or do it via other
                            accounts</span>
                    </div>

                    <div class="flex justify-center space-x-4">
                        <a href="#" class="p-3 rounded-full border border-gray-200 hover:bg-gray-50 transition">
                            <svg class="w-6 h-6" viewBox="0 0 24 24">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                        </a>
                        <a href="#" class="p-3 rounded-full border border-gray-200 hover:bg-gray-50 transition">
                            <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.74 1.18 0 2.45-1.02 4.12-.55 2.1.56 3.2 2.68 3.73 3.44-3.32 1.6-2.74 5.95.6 7.28-.48 1.4-1.2 2.8-2.23 3.86l-.15.2zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z" />
                            </svg>
                        </a>
                        <a href="#" class="p-3 rounded-full border border-gray-200 hover:bg-gray-50 transition">
                            <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                            </svg>
                        </a>
                    </div>

                </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">
                        Already have an account? <a href="{{ route('login') }}"
                            class="font-bold text-black hover:underline" wire:navigate>Sign In</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>