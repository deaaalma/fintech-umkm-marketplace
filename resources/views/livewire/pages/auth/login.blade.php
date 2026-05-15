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

        // 👇 LOGIKA REDIRECT BERDASARKAN ROLE 👇

        $role = auth()->user()->role;

        // Tentukan mau kemana berdasarkan role
        $redirectUrl = match ($role) {
            'superadmin' => route('admin.dashboard', absolute: false),
            'admin_umkm' => route('umkm.dashboard', absolute: false),
            'worker' => route('worker.dashboard', absolute: false),
            'customer' => route('customer.dashboard', absolute: false),
            default => route('dashboard', absolute: false), // customer lari kesini
        };

        // RedirectIntended artinya: 
        // Kalau user tadi mau buka halaman Admin tapi dihadang login, balikin ke Admin.
        // Tapi kalau login biasa, arahkan ke $redirectUrl yang kita set diatas.
        $this->redirectIntended(default: $redirectUrl, navigate: true);
    }
}; ?>



<div class="flex min-h-screen w-full bg-white">

    <div class="hidden lg:flex w-1/2 bg-gray-600 flex-col justify-between p-12 text-white relative overflow-hidden"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset('storage/images/auth.jpg') }}'); background-size: cover; background-position: center;">

        <div class="relative z-10">
            <a href="/"
                class="inline-flex items-center px-4 py-2 bg-white text-gray-800 rounded-full font-bold text-lg shadow-md"
                wire:navigate>
                UMKM System
            </a>
        </div>

        <div class="flex flex-col items-start space-y-6 relative z-10">
            <h1 class="text-4xl font-bold">Welcome Back!</h1>
            <p class="text-gray-200 text-lg max-w-md">
                Login to continue accessing your account and enjoy our services from trusted UMKM partners.
            </p>
        </div>

        <div class="text-sm text-gray-400 relative z-10">
            &copy; {{ date('Y') }} UMKM System.
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <h2 class="text-3xl font-bold text-gray-900 mb-2">Login</h2>
            <p class="text-gray-500 mb-8">Enter your credentials to continue</p>

            <form wire:submit="login" class="space-y-6" x-data="{ showPassword: false }">

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email or phone
                        number</label>
                    <input wire:model="form.email" type="email" id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-3 placeholder-gray-400"
                        placeholder="Email address" required autofocus autocomplete="username">

                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <div class="relative">
                        <input wire:model="form.password" :type="showPassword ? 'text' : 'password'" id="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-3 pr-10 placeholder-gray-400"
                            placeholder="Enter your password" required autocomplete="current-password">

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

                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input wire:model="form.remember" id="remember" type="checkbox"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500">Remember me</label>
                        </div>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-gray-600 hover:text-black"
                            wire:navigate>
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Login</span>
                    <span wire:loading>Loading...</span>
                </button>

                <div class="relative flex items-center justify-center my-6">
                    <div class="w-full border-t border-gray-300"></div>
                    <span class="absolute bg-white px-3 text-gray-500 text-sm">or do it via other accounts</span>
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

            <div class="mt-6 text-center">
                <p class="text-sm font-light text-gray-500">
                    Don’t have an account? <a href="{{ route('register') }}"
                        class="font-bold text-black hover:underline" wire:navigate>Sign Up</a>
                </p>
            </div>
        </div>
    </div>
</div>