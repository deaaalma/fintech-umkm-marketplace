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
            $this->handleRedirect($user);
            return;
        }

        $this->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        if ($user->otp_code !== $this->otp || now()->greaterThan($user->otp_expires_at)) {
            throw ValidationException::withMessages([
                'otp' => __('Kode OTP salah atau sudah kadaluarsa.'),
            ]);
        }

        $user->email_verified_at = now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        Session::flash('status', 'verification-successful');
        $this->handleRedirect($user);
    }

    private function handleRedirect($user): void
    {
        if ($user->role === 'admin_umkm') {
            $this->redirect(route('umkm.setup', absolute: false), navigate: true);
            return;
        }

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            return;
        }

        $user = Auth::user();
        $otpCode = (string) rand(100000, 999999);
        $user->otp_code = $otpCode;
        $user->otp_expires_at = now()->addMinutes(30);
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otpCode));
        Session::flash('status', 'verification-link-sent');
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; 
?>

<div class="flex w-full bg-[#f8fafc] font-['Figtree'] selection:bg-[#0077B6]/10 selection:text-[#0077B6]">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&family=Inter:wght@100..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');

        .font-figtree { font-family: 'Figtree', sans-serif; }
        .font-plus { font-family: 'Plus Jakarta Sans', sans-serif; }

        .brand-gradient-verify {
            background: linear-gradient(135deg, #000B44 0%, #004E89 100%);
        }

        .input-focus-verify:focus {
            border-color: #0077B6 !important;
            box-shadow: 0 0 0 4px rgba(0, 119, 182, 0.1) !important;
        }

        .glass-effect-verify {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>

    {{-- Left Column: Sticky --}}
    <div class="hidden lg:flex w-1/2 flex-col justify-between p-16 text-white relative overflow-hidden brand-gradient-verify sticky top-0 h-screen flex-shrink-0">
        <div class="absolute inset-0 opacity-20"
             style="background-image: url('{{ asset('storage/images/auth.jpg') }}'); background-size: cover; background-position: center; mix-blend-mode: overlay;">
        </div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#0077B6] rounded-full blur-[100px] opacity-20"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#0077B6] rounded-full blur-[100px] opacity-20"></div>

        <div class="relative z-10">
            <a href="/"
                class="inline-flex items-center px-6 py-3 bg-white/10 glass-effect-verify rounded-2xl font-plus font-bold text-lg tracking-tight hover:bg-white/20 transition-all duration-300"
                wire:navigate>
                <span class="text-white">JOS</span>
            </a>
        </div>

        <div class="flex flex-col items-start space-y-8 relative z-10">
            <h1 class="font-black leading-none" style="font-size: 80px; font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.04em;">Cek email Anda!</h1>
            <p style="font-size: 20px; line-height: 1.6; font-family: 'Inter', sans-serif; font-weight: 300; color: rgba(219,234,254,0.7); letter-spacing: 0.01em; max-width: 520px;">
                Kami hampir selesai! Silakan verifikasi alamat email Anda untuk melanjutkan akses ke akun Anda.
            </p>
        </div>

        <div class="text-sm font-medium text-blue-200/50 relative z-10 font-plus tracking-wider">
            &copy; {{ date('Y') }} JOS
        </div>
    </div>

    {{-- Right Column: Scrollable --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-16 bg-[#f8fafc] overflow-y-auto min-h-screen">
        <div class="w-full max-w-md py-8">

            {{-- Mobile Logo --}}
            <div class="lg:hidden mb-10">
                <span class="text-2xl font-plus font-black text-[#000B44]">JOS</span>
            </div>

            @if (session('status') == 'verification-successful')
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg animate-pulse">
                    <p class="font-bold text-green-800 text-sm">Verifikasi Berhasil!</p>
                    <p class="text-green-700 text-xs">Mengarahkan Anda ke dashboard...</p>
                </div>
            @endif

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-[#0077B6] rounded-lg">
                    <p class="font-bold text-[#000B44] text-sm">OTP Baru Terkirim!</p>
                    <p class="text-slate-600 text-xs">Silakan cek kotak masuk atau folder spam email Anda.</p>
                </div>
            @endif

            <div class="mb-10">
                <h2 class="text-4xl font-black text-[#000B44] mb-3 font-plus tracking-tight">Verifikasi Email</h2>
                <p class="text-slate-500 font-medium">Masukkan 6 digit kode OTP yang kami kirimkan ke email Anda.</p>
            </div>

            <form wire:submit="verifyOtp" class="space-y-8">
                <div class="space-y-4">
                    <label for="otp" class="text-sm font-bold text-[#000B44] font-plus tracking-wide uppercase opacity-70">Kode OTP</label>
                    <div class="relative group">
                        <input wire:model="otp" type="text" id="otp"
                            class="w-full px-5 py-6 bg-white border-2 border-slate-100 rounded-2xl font-black text-[#000B44] text-4xl text-center tracking-[0.5em] transition-all duration-300 input-focus-verify placeholder:text-slate-200"
                            placeholder="000000" maxlength="6" required autofocus autocomplete="off">
                    </div>
                    <x-input-error :messages="$errors->get('otp')" class="mt-2 text-xs font-bold text-red-500 text-center" />
                </div>

                <div class="space-y-4">
                    <button type="submit"
                        class="w-full bg-[#000B44] hover:bg-[#0077B6] text-white font-black font-plus py-4 rounded-2xl shadow-xl shadow-[#000B44]/10 hover:shadow-[#0077B6]/20 transition-all duration-300 transform hover:-translate-y-1 disabled:opacity-50 flex justify-center items-center gap-3"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Verifikasi OTP</span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>

                    <div class="flex flex-col gap-4 text-center">
                        <button wire:click.prevent="sendVerification"
                            class="text-sm font-black text-[#0077B6] hover:text-[#000B44] transition-colors border-b-2 border-[#0077B6]/10 hover:border-[#000B44] pb-1 self-center">
                            Kirim Ulang Email OTP
                        </button>

                        <p class="text-sm font-semibold text-slate-500 italic">
                            Salah akun? <button wire:click.prevent="logout"
                                class="text-[#000B44] font-black hover:text-red-500 transition-colors">Keluar Sekarang</button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>