<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
    #[Layout('layouts.blank')]
    class extends Component {
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


<div class="min-h-screen flex items-center justify-center p-4 bg-gray-100">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6">

        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900">Forgot Password?</h1>
            <p class="mt-2 text-sm text-gray-500 text-center leading-relaxed">
                Enter your email or phone number and we'll send you a link to reset your password.
            </p>
        </div>

        <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

        <form wire:submit="sendPasswordResetLink" class="space-y-6">

            <div>
                <label for="email" class="block mb-2 text-xs font-bold text-gray-600 uppercase">Email or phone
                    number</label>
                <input wire:model="email" id="email" type="email" name="email"
                    class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-3 placeholder-gray-400"
                    placeholder="Enter your registered email or phone" required autofocus>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button type="submit"
                class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition duration-150 ease-in-out disabled:opacity-50"
                wire:loading.attr="disabled">
                <span wire:loading.remove>Send Reset Link</span>
                <span wire:loading>Sending...</span>
            </button>

        </form>

        <div class="flex items-center justify-center mt-6">
            <a href="{{ route('login') }}"
                class="flex items-center text-sm text-gray-500 hover:text-gray-900 transition" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Login
            </a>
        </div>

    </div>
</div>