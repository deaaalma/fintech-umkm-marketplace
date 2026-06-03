<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-900 font-plus tracking-tight mb-2">Profil Saya</h1>
        <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">Kelola informasi akun dan keamanan Anda</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-8 p-4 bg-green-50 border border-green-100 rounded-2xl text-green-600 text-sm font-bold flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-8">
        {{-- Personal Info Card --}}
        <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm space-y-10">
            <h2 class="text-xl font-black text-gray-900 font-plus">Informasi Pribadi</h2>

            {{-- Profile Photo --}}
            <div class="flex flex-col md:flex-row items-start gap-10">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-[32px] bg-gray-100 border-4 border-white shadow-lg overflow-hidden">
                        @if ($profile_photo)
                            <img src="{{ $profile_photo->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif (auth()->user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-3xl font-black text-gray-300">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <label class="absolute -bottom-2 -right-2 w-10 h-10 bg-[#2D2D2D] rounded-xl border-4 border-white text-white flex items-center justify-center cursor-pointer hover:bg-black transition-all shadow-md">
                        <input type="file" wire:model="profile_photo" class="hidden">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </label>
                </div>
                <div class="flex-1 space-y-2">
                    <h4 class="text-sm font-black text-gray-900 font-plus">Foto Profil</h4>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Format: JPG, PNG. Maksimal 2MB.</p>
                    <div class="mt-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Foto untuk identifikasi internal dan penugasan</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Name --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-0 focus:border-[#2D2D2D] transition-all outline-none">
                    @error('name') <span class="text-[10px] text-red-500 font-bold ml-4">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Email</label>
                    <input type="email" wire:model="email" disabled class="w-full px-6 py-4 bg-gray-100 border border-gray-100 rounded-2xl text-sm font-bold text-gray-400 cursor-not-allowed">
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest ml-4">Email tidak dapat diubah karena digunakan sebagai identitas login</p>
                </div>

                {{-- Phone --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Nomor Telepon</label>
                    <input type="text" wire:model="phone" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-0 focus:border-[#2D2D2D] transition-all outline-none">
                    @error('phone') <span class="text-[10px] text-red-500 font-bold ml-4">{{ $message }}</span> @enderror
                </div>

                {{-- Address --}}
                <div class="space-y-3 md:col-span-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Alamat</label>
                    <textarea wire:model="address" rows="3" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-[28px] text-sm font-bold focus:ring-0 focus:border-[#2D2D2D] transition-all outline-none resize-none" placeholder="Masukkan alamat lengkap"></textarea>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest ml-4">Digunakan untuk kebutuhan komunikasi dan operasional</p>
                </div>
            </div>

            {{-- Availability --}}
            <div class="space-y-6 pt-6 border-t border-gray-50">
                <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-widest">Ketersediaan Hari & Jam</h3>
                <div class="space-y-6">
                    @foreach($availability as $day => $data)
                    <div @class([
                        'space-y-4 p-6 rounded-[32px] border transition-all duration-300',
                        'bg-blue-50/30 border-blue-100 shadow-sm' => $data['active'],
                        'bg-gray-50 border-gray-100' => !$data['active']
                    ])>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="availability.{{ $day }}.active" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                                <span @class([
                                    'text-sm font-black font-plus transition-colors',
                                    'text-blue-900' => $data['active'],
                                    'text-gray-900' => !$data['active']
                                ])>{{ $day }}</span>
                            </div>
                            <span @class([
                                'text-[10px] font-black uppercase tracking-widest transition-colors',
                                'text-blue-600' => $data['active'],
                                'text-gray-400' => !$data['active']
                            ])>{{ $data['active'] ? 'Tersedia' : 'Tidak tersedia' }}</span>
                        </div>

                        {{-- Time Slots --}}
                        @if($data['active'])
                        <div class="ml-10 space-y-3 animate-fade-in">
                            @foreach($data['slots'] as $index => $slot)
                            <div class="flex items-center gap-4">
                                <div class="w-32 relative">
                                    <input type="time" wire:model="availability.{{ $day }}.slots.{{ $index }}.time" class="w-full px-4 py-3 bg-white border border-gray-100 rounded-xl text-xs font-bold focus:ring-0 focus:border-[#2D2D2D] outline-none">
                                </div>
                                <button type="button" wire:click="removeSlot('{{ $day }}', {{ $index }})" class="p-3 text-red-400 hover:text-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                            @endforeach
                            <button type="button" wire:click="addSlot('{{ $day }}')" class="text-[10px] font-black text-[#2D2D2D] hover:text-black uppercase tracking-widest flex items-center gap-2 px-2 py-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                Tambah Jam Kerja
                            </button>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Aktifkan toggle untuk setiap hari Anda tersedia, kemudian Anda bisa menambahkan satu atau lebih rentang jam kerja.</p>
            </div>
        </div>

        {{-- Account Security Card --}}
        <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm space-y-10">
            <h2 class="text-xl font-black text-gray-900 font-plus">Keamanan Akun</h2>

            <div class="grid grid-cols-1 gap-8 max-w-xl">
                {{-- Old Password --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Password Lama</label>
                    <input type="password" wire:model="old_password" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-0 focus:border-[#2D2D2D] transition-all outline-none" placeholder="Masukkan password lama">
                    @error('old_password') <span class="text-[10px] text-red-500 font-bold ml-4">{{ $message }}</span> @enderror
                </div>

                {{-- New Password --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Password Baru</label>
                    <input type="password" wire:model="new_password" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-0 focus:border-[#2D2D2D] transition-all outline-none" placeholder="Masukkan password baru">
                    @error('new_password') <span class="text-[10px] text-red-500 font-bold ml-4">{{ $message }}</span> @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Konfirmasi Password Baru</label>
                    <input type="password" wire:model="new_password_confirmation" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:ring-0 focus:border-[#2D2D2D] transition-all outline-none" placeholder="Ketik ulang password baru">
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="bg-white p-8 rounded-[32px] border border-gray-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                Mencegah submit data tidak valid | Disabled jika tidak ada perubahan | Loading state saat submit
            </div>
            <div class="flex items-center gap-4">
                <button type="button" class="px-8 py-4 bg-gray-50 hover:bg-gray-100 text-gray-400 rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
                    Batal
                </button>
                <button type="submit" wire:loading.attr="disabled" class="px-10 py-4 bg-[#2D2D2D] hover:bg-black text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-gray-200">
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </div>
    </form>
</div>
