<x-mail::message>
    # Verify your email address

    Thank you for registering! Please use the following OTP (One-Time Password) to verify your email address and
    complete your registration.

    <x-mail::panel>
        # {{ $otpCode }}
    </x-mail::panel>

    This OTP will expire in 30 minutes.

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>