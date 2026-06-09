<div class="max-w-4xl mx-auto animate-fade-in-up font-plus" x-data>
    <style>
        .p-input {
            width: 100%;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            padding-left: 1.25rem;
            padding-right: 1.25rem;
            background: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            outline: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .p-input:focus {
            border-color: #0077B6;
            box-shadow: 0 0 0 4px rgba(0, 119, 182, 0.1);
            background: #fff;
        }
        .p-input:disabled {
            background: #F1F5F9;
            color: #94A3B8;
            cursor: not-allowed;
        }
        .p-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748B;
            margin-bottom: 0.5rem;
        }
    </style>

    {{-- ============================================================
         FLASH MESSAGES
    ============================================================ --}}
    @if(session('successMessage') || $successMessage)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="flex items-center gap-3 px-5 py-4 mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-bold shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('successMessage') ?? $successMessage }}
        </div>
    @endif

    @if($errorMessage)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="flex items-center gap-3 px-5 py-4 mb-6 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-bold shadow-sm">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $errorMessage }}
        </div>
    @endif

    {{-- ============================================================
         VIEW: PROFILE (DATA PRIBADI)
    ============================================================ --}}
    @if($viewState === 'profile')
    <form wire:submit.prevent="savePersonal">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">

            {{-- Solid Navy Banner --}}
            <div class="h-32 bg-[#000B44] relative overflow-hidden"></div>

            {{-- Profile Header Row --}}
            <div class="px-6 sm:px-8 pb-6">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    
                    {{-- Left: Avatar + Details --}}
                    <div class="flex flex-col sm:flex-row items-center sm:items-end gap-5 w-full text-center sm:text-left">
                        
                        {{-- Avatar: Pulled up to overlap the banner --}}
                        <div class="relative w-24 h-24 shrink-0 -mt-12 z-10">
                            <div class="w-full h-full rounded-full border-4 border-white shadow-md overflow-hidden bg-[#000B44] flex items-center justify-center">
                                @if($profile_photo)
                                    <img src="{{ $profile_photo->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview">
                                @elseif($user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                                @else
                                    <span class="text-3xl font-extrabold text-white select-none">
                                        {{ strtoupper(substr($name ?: ($user->name ?: 'U'), 0, 1)) }}
                                    </span>
                                @endif
                            </div>

                            {{-- Camera badge (Only shown when editing) --}}
                            @if($isEditing)
                            <label class="absolute bottom-0 right-0 w-7 h-7 bg-[#0077B6] hover:bg-[#005f8e] rounded-full flex items-center justify-center cursor-pointer shadow-md border-2 border-white transition-colors" title="Ganti foto">
                                <input type="file" wire:model="profile_photo" class="hidden" accept="image/*">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </label>
                            @endif

                            {{-- Upload spinner --}}
                            <div wire:loading wire:target="profile_photo"
                                 class="absolute inset-0 rounded-full bg-black/60 flex items-center justify-center border-4 border-white z-20">
                                <svg class="animate-spin w-6 h-6 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div class="flex-1 min-w-0 pt-4 sm:pt-4 pb-1 z-10">
                            <h2 class="text-xl sm:text-2xl font-extrabold text-[#000B44] tracking-tight leading-tight truncate">
                                {{ $name ?: ($user->name ?: 'Customer') }}
                            </h2>
                            <p class="text-sm font-semibold text-slate-500 mt-1 flex items-center justify-center sm:justify-start gap-1.5 truncate">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>

                    {{-- Right: Actions --}}
                    <div class="flex items-center justify-center sm:justify-end gap-2 shrink-0 md:pb-1 pt-2 sm:pt-0">
                        @if($isEditing)
                            <button type="button" wire:click="cancelEdit"
                                    class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all active:scale-95">
                                Batal
                            </button>
                            <button type="submit"
                                    class="flex items-center gap-2 px-6 py-2.5 bg-[#0077B6] hover:bg-[#005f8e] text-white text-sm font-black rounded-xl transition-all shadow-sm active:scale-95">
                                <span wire:loading.remove wire:target="savePersonal" class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan
                                </span>
                                <span wire:loading wire:target="savePersonal" class="flex items-center gap-1.5">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Menyimpan...
                                </span>
                            </button>
                        @else
                            <button type="button" wire:click="$set('isEditing', true)"
                                    class="flex items-center gap-2 px-6 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-sm font-black rounded-xl transition-all shadow-sm active:scale-95">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit Profil
                            </button>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-slate-100"></div>

            {{-- Form Body --}}
            <div class="px-6 sm:px-8 py-8 space-y-6">

                {{-- Photo Preview Notice --}}
                @if($profile_photo)
                    <div class="flex items-center gap-3 px-4 py-3.5 bg-blue-50 border border-blue-100 rounded-2xl text-sm font-semibold text-[#0077B6] animate-fade-in-up">
                        <img src="{{ $profile_photo->temporaryUrl() }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow">
                        <span>Foto baru dipilih. Klik <strong>Simpan</strong> untuk menerapkan perubahan.</span>
                        <button type="button" wire:click="$set('profile_photo', null)" class="ml-auto text-slate-400 hover:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- 2-Column Form Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="p-label">Nama Lengkap</label>
                        @if($isEditing)
                            <input type="text" wire:model="name" class="p-input" placeholder="Nama Lengkap Anda">
                            @error('name') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        @else
                            <div class="px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-xl text-sm font-extrabold text-slate-900">
                                {{ $name ?: '-' }}
                            </div>
                        @endif
                    </div>

                    {{-- Nomor Telepon --}}
                    <div>
                        <label class="p-label">Nomor Telepon / WA</label>
                        @if($isEditing)
                            <input type="text" wire:model="phone" class="p-input" placeholder="0812 3456 7890">
                            @error('phone') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        @else
                            <div class="px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-xl text-sm font-extrabold text-slate-900">
                                {{ $phone ?: '-' }}
                            </div>
                        @endif
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="p-label">Tanggal Lahir</label>
                        @if($isEditing)
                            <input type="date" wire:model="date_of_birth" class="p-input">
                            @error('date_of_birth') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        @else
                            <div class="px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-xl text-sm font-extrabold text-slate-900">
                                {{ $date_of_birth ? \Carbon\Carbon::parse($date_of_birth)->translatedFormat('d F Y') : '-' }}
                            </div>
                        @endif
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label class="p-label">NIK <span class="text-slate-300 font-medium normal-case tracking-normal">(16 digit)</span></label>
                        @if($isEditing)
                            <input type="text" wire:model="nik" maxlength="16" class="p-input" placeholder="Nomor Induk Kependudukan">
                            @error('nik') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        @else
                            <div class="px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-xl text-sm font-extrabold text-slate-900">
                                {{ $nik ?: '-' }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Alamat (full width) --}}
                <div>
                    <label class="p-label">Alamat Lengkap</label>
                    @if($isEditing)
                        <textarea wire:model="address" rows="3"
                                  class="p-input resize-none"
                                  placeholder="Jl. Raya No. 12, Kel. ..., Kec. ..., Kota ..., Prov. ..."></textarea>
                        @error('address') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        <p class="mt-1.5 text-[11px] text-slate-400 font-semibold">Digunakan untuk keperluan layanan kunjungan / pengiriman barang</p>
                    @else
                        <div class="px-5 py-3.5 min-h-[5rem] bg-slate-50 border border-slate-100 rounded-xl text-sm font-extrabold text-slate-900">
                            {{ $address ?: '-' }}
                        </div>
                    @endif
                </div>

                {{-- Email Address Display --}}
                <div class="pt-4 border-t border-slate-100">
                    <h3 class="flex items-center gap-2 text-sm font-black text-[#000B44] mb-3">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Alamat Email
                    </h3>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-200/60">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="w-10 h-10 bg-[#0077B6]/10 text-[#0077B6] rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $user->email }}</p>
                                <p class="text-xs text-slate-400 font-medium mt-0.5">Email utama · tidak dapat diubah</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    {{-- Keamanan Akun Section --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <h3 class="flex items-center gap-2 text-lg font-black text-[#000B44] mb-1">
            Keamanan Akun
        </h3>
        <p class="text-sm text-slate-500 font-medium mb-6">Kelola kata sandi atau hapus akun Anda secara permanen di sini.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Tombol Ganti Password --}}
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-200/60 hover:border-slate-300 transition-colors">
                <div class="mr-4">
                    <p class="text-sm font-bold text-slate-800">Ganti Password</p>
                    <p class="text-[11px] text-slate-500 font-medium mt-0.5">Ubah kata sandi untuk mengamankan akun</p>
                </div>
                <button type="button" wire:click="changeViewState('password')"
                        class="shrink-0 px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-sm font-bold rounded-xl transition-all shadow-sm active:scale-95">
                    Ganti
                </button>
            </div>

            {{-- Tombol Hapus Akun --}}
            <div class="flex items-center justify-between p-4 bg-red-50/50 rounded-2xl border border-red-100 hover:border-red-200 transition-colors">
                <div class="mr-4">
                    <p class="text-sm font-bold text-red-700">Hapus Akun</p>
                    <p class="text-[11px] text-red-500/80 font-medium mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <button type="button" wire:click="confirmDelete"
                        class="shrink-0 px-4 py-2 bg-red-600 text-white hover:bg-red-700 text-sm font-bold rounded-xl transition-all shadow-sm active:scale-95">
                    Hapus
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ============================================================
         VIEW: KEAMANAN (GANTI PASSWORD)
    ============================================================ --}}
    @if($viewState === 'password')
    <form wire:submit.prevent="{{ $isPasswordVerified ? 'savePassword' : 'verifyCurrentPassword' }}" class="animate-fade-in-up">
        
        {{-- Back Button Header --}}
        <button type="button" wire:click="changeViewState('profile')"
                class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#000B44] transition-colors mb-6 group">
            <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-[#000B44] group-hover:bg-[#000B44] group-hover:text-white transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </div>
            Kembali ke Profil
        </button>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-center gap-3 bg-[#000B44]">
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-black text-white leading-tight">Ganti Password</h2>
                    <p class="text-xs text-white/70 font-medium mt-0.5">Pastikan password baru Anda kuat dan aman</p>
                </div>
            </div>

            <div class="p-6 sm:p-8 max-w-lg space-y-5">
                
                @if(!$isPasswordVerified)
                    {{-- Current Password Verification --}}
                    <div x-data="{ show: false }">
                        <label class="p-label">Password Saat Ini</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" wire:model="current_password" class="p-input pr-12" placeholder="Masukkan password lama">
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        @error('current_password') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>
                @else
                    {{-- Verified Banner --}}
                    <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-xs font-bold shadow-sm mb-6">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Password lama terverifikasi. Silakan masukkan password baru Anda.
                    </div>

                    {{-- New Password --}}
                    <div x-data="{ show: false }">
                        <label class="p-label">Password Baru</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" wire:model="new_password" class="p-input pr-12" placeholder="Minimal 8 karakter">
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        @error('new_password') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div x-data="{ show: false }">
                        <label class="p-label">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input :type="show ? 'text' : 'password'" wire:model="new_password_confirmation" class="p-input pr-12" placeholder="Ulangi password baru">
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        @error('new_password_confirmation') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tips --}}
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-[11px] font-black text-slate-500 uppercase tracking-wider mb-2">Tips Password Kuat:</p>
                        <ul class="space-y-1.5">
                            @foreach(['Minimal 8 karakter', 'Kombinasi huruf besar & kecil', 'Gunakan angka dan simbol (@, #, !)'] as $tip)
                            <li class="flex items-center gap-2 text-[11px] text-slate-500 font-semibold">
                                <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $tip }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex justify-end pt-2">
                    @if(!$isPasswordVerified)
                        <button type="submit"
                                class="flex items-center gap-2 px-8 py-3 bg-[#000B44] text-white text-sm font-black rounded-xl hover:bg-[#001166] transition-all shadow-sm active:scale-95">
                            <span wire:loading.remove wire:target="verifyCurrentPassword" class="flex items-center gap-1.5">
                                Verifikasi Password
                            </span>
                            <span wire:loading wire:target="verifyCurrentPassword" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Memverifikasi...
                            </span>
                        </button>
                    @else
                        <button type="submit"
                                class="flex items-center gap-2 px-8 py-3 bg-[#0077B6] text-white text-sm font-black rounded-xl hover:bg-[#005f8e] transition-all shadow-sm active:scale-95">
                            <span wire:loading.remove wire:target="savePassword" class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Perbarui Password
                            </span>
                            <span wire:loading wire:target="savePassword" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Memperbarui...
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </form>
    @endif

    {{-- ============================================================
         DELETE CONFIRM MODAL
    ============================================================ --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 z-[200] flex items-center justify-center p-4"
         x-data x-init="$el.style.backdropFilter='blur(6px)'"
         style="background: rgba(0, 0, 0, 0.4);">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-fade-in-up"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <div class="p-8 text-center border-b border-slate-100">
                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-[#000B44] mb-2">Konfirmasi Hapus Akun</h3>
                <p class="text-sm text-slate-500 font-semibold leading-relaxed">
                    Masukkan password Anda untuk mengonfirmasi penghapusan akun. Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <div class="p-8 space-y-5" x-data="{ show: false }">
                <div>
                    <label class="p-label">Konfirmasi Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" wire:model="delete_password" class="p-input pr-12" placeholder="Masukkan password Anda">
                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" wire:click="$set('showDeleteModal', false)"
                            class="flex-1 px-5 py-3 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="button" wire:click="deleteAccount"
                            class="flex-1 flex items-center justify-center gap-2 px-5 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-black rounded-xl transition-all active:scale-95">
                        <span wire:loading.remove wire:target="deleteAccount">Ya, Hapus Akun</span>
                        <span wire:loading wire:target="deleteAccount" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Menghapus...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
