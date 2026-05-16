<?php

use App\Livewire\Actions\Logout;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.blank')] class extends Component {
    public string $otp = '';

    /**
     * Verify the OTP code.
     */
    public function verifyOtp(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            // Redirect based on role or to a default onboarding
            $this->redirectIntended(default: route('onboarding', absolute: false), navigate: true);
            return;
        }

        $this->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        if ($user->otp_code !== $this->otp || now()->greaterThan($user->otp_expires_at)) {
            throw ValidationException::withMessages([
                'otp' => __('The provided OTP is incorrect or has expired.'),
            ]);
        }

        $user->email_verified_at = now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        Session::flash('status', 'verification-successful');

        $this->redirectIntended(default: route('onboarding', absolute: false), navigate: true);
    }

    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('onboarding', absolute: false), navigate: true);

            return;
        }

        $user = Auth::user();

        // Generate a new 6 digit OTP
        $otpCode = (string) rand(100000, 999999);
        $user->otp_code = $otpCode;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otpCode));

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
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
            <h1 class="text-4xl font-bold">Verify Your Email</h1>
            <p class="text-gray-200 text-lg max-w-md">
                Almost there! Please verify your email address to continue accessing your account.
            </p>
        </div>

        <div class="text-sm text-gray-400 relative z-10">
            &copy; {{ date('Y') }} UMKM System.
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">

            @if (session('status') == 'verification-successful')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('Verification successful. Redirecting...') }}
                </div>
            @endif
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new OTP code has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <h2 class="text-3xl font-bold text-gray-900 mb-2">Verify email</h2>
            <p class="text-gray-500 mb-8">We have sent a 6-digit OTP code to your email address.</p>

            <form wire:submit="verifyOtp" class="space-y-6">

                <div>
                    <label for="otp" class="block mb-2 text-sm font-medium text-gray-900">OTP Code</label>
                    <input wire:model="otp" type="text" id="otp"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-3 placeholder-gray-400 text-center tracking-widest font-bold"
                        placeholder="123456" required autofocus autocomplete="off">

                    <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                </div>

                <button type="submit"
                    class="w-full text-white bg-black hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Verify OTP</span>
                    <span wire:loading>Loading...</span>
                </button>

                <div class="flex flex-col space-y-4 text-center mt-6">
                    <button wire:click.prevent="sendVerification"
                        class="text-sm font-bold text-black hover:underline focus:outline-none">
                        Resend OTP Email
                    </button>

                    <p class="text-sm font-light text-gray-500">
                        Wrong account? <button wire:click.prevent="logout"
                            class="font-bold text-black hover:underline focus:outline-none">Log Out</button>
                    </p>
                </div>

            </form>
        </div>
    </div>
</div>