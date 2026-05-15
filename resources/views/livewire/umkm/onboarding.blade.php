
    <div class="min-h-screen bg-[#F8F9FA] py-12 px-4 sm:px-6 lg:px-8 font-sans" x-data="{ step: @entangle('step') }">
        <div class="max-w-3xl mx-auto">

            <!-- Header & Progress Bar -->
            <div class="mb-10 text-center relative max-w-xl mx-auto">
                <!-- connecting line -->
                <div class="absolute top-5 left-10 right-10 h-[2px] bg-gray-200 z-0"></div>

                <div class="flex justify-between relative z-10">
                    <!-- Step 1 Indicator -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors duration-300"
                            :class="step >= 1 ? 'bg-gray-800 border-gray-800 text-white' : 'bg-gray-100 border-gray-200 text-gray-400'">
                            <span x-show="step === 1">1</span>
                            <svg x-show="step > 1" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold mt-2"
                            :class="step >= 1 ? 'text-gray-800' : 'text-gray-400'">Informasi Bisnis</span>
                    </div>

                    <!-- Step 2 Indicator -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors duration-300"
                            :class="step >= 2 ? 'bg-gray-800 border-gray-800 text-white' : 'bg-white border-gray-300 text-gray-400'">
                            <span x-show="step <= 2">2</span>
                            <svg x-show="step > 2" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold mt-2"
                            :class="step >= 2 ? 'text-gray-800' : 'text-gray-400'">Data
                            Pemilik</span>
                    </div>

                    <!-- Step 3 Indicator -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors duration-300"
                            :class="step >= 3 ? 'bg-gray-800 border-gray-800 text-white' : 'bg-white border-gray-300 text-gray-400'">
                            <span x-show="step <= 3">3</span>
                            <svg x-show="step > 3" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold mt-2"
                            :class="step >= 3 ? 'text-gray-800' : 'text-gray-400'">Dokumen</span>
                    </div>

                    <!-- Step 4 Indicator -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors duration-300"
                            :class="step >= 4 ? 'bg-gray-800 border-gray-800 text-white' : 'bg-white border-gray-300 text-gray-400'">
                            <span x-show="step <= 4">4</span>
                            <svg x-show="step > 4" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold mt-2"
                            :class="step >= 4 ? 'text-gray-800' : 'text-gray-400'">Rekening</span>
                    </div>

                    <!-- Step 5 Indicator -->
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-colors duration-300"
                            :class="step >= 5 ? 'bg-gray-800 border-gray-800 text-white' : 'bg-white border-gray-300 text-gray-400'">
                            <span>5</span>
                        </div>
                        <span class="text-xs font-semibold mt-2"
                            :class="step >= 5 ? 'text-gray-800' : 'text-gray-400'">Review</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:p-10 p-6 border border-gray-100">

                <!-- Step 1 Form: Informasi Bisnis -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Informasi Bisnis</h2>
                    <p class="text-gray-500 text-sm mb-8">Ceritakan tentang bisnis UMKM Anda</p>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Bisnis <span
                                    class="text-red-500">*</span></label>
                            <input wire:model="business_name" type="text"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all"
                                placeholder="Contoh: GWP Cleaning Service">
                            <p class="mt-1.5 text-xs text-gray-400">Nama yang akan ditampilkan kepada customer</p>
                            @error('business_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Kategori Bisnis <span
                                    class="text-red-500">*</span></label>
                            <input wire:model="business_category" type="text"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all"
                                placeholder="Cleaning Service, Laundry, Catering, dll">
                            <p class="mt-1.5 text-xs text-gray-400">Pilih kategori yang paling sesuai</p>
                            @error('business_category') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Deskripsi Singkat <span
                                    class="text-red-500">*</span></label>
                            <textarea wire:model="business_description" rows="4"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all resize-none"
                                placeholder="Jelaskan tentang bisnis Anda, pengalaman, dan keunggulan..."></textarea>
                            <p class="mt-1.5 text-xs text-gray-400">0/500 karakter</p>
                            @error('business_description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input wire:model="business_address" type="text"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all"
                                placeholder="Jalan, Nomor, RT/RW, Kelurahan, Kecamatan">
                            <p class="mt-1.5 text-xs text-gray-400">Alamat operasional bisnis</p>
                            @error('business_address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Kota <span
                                        class="text-red-500">*</span></label>
                                <input wire:model="business_city" type="text"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all"
                                    placeholder="Jakarta">
                                @error('business_city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Nomor Telepon <span
                                        class="text-red-500">*</span></label>
                                <input wire:model="business_phone" type="text"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all"
                                    placeholder="08123456789">
                                @error('business_phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Lokasi Peta</label>
                            <div
                                class="w-full h-48 bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400 mt-2">
                                <div class="w-10 h-10 bg-gray-300 rounded-lg mb-2"></div>
                                <p class="text-sm font-semibold text-gray-600">Peta Lokasi Bisnis</p>
                                <p class="text-xs">Klik untuk menandai kordinat utama</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 Form: Data Pemilik -->
                <div x-cloak x-show="step === 2" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Data Pemilik</h2>
                    <p class="text-gray-500 text-sm mb-8">Informasi penanggung jawab bisnis</p>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Lengkap Pemilik <span
                                    class="text-red-500">*</span></label>
                            <input wire:model="owner_name" type="text"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all"
                                placeholder="Nama lengkap">
                            <p class="mt-1.5 text-xs text-gray-400">Sesuai dengan KTP</p>
                            @error('owner_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">NIK (Nomor Induk Kependudukan)
                                <span class="text-red-500">*</span></label>
                            <input wire:model="owner_nik" type="text"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all"
                                placeholder="3174012345678901">
                            <p class="mt-1.5 text-xs text-gray-400">16 digit sesuai KTP</p>
                            @error('owner_nik') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal Lahir <span
                                    class="text-red-500">*</span></label>
                            <input wire:model="owner_birthdate" type="date"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all">
                            @error('owner_birthdate') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Upload Foto KTP</label>
                                <div
                                    class="w-full bg-gray-50 rounded-xl border border-gray-200 p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gray-400 rounded flex-shrink-0"></div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">ktp_pemilik.jpg</p>
                                            <p class="text-xs text-gray-500">2.4 MB • JPG</p>
                                        </div>
                                    </div>
                                    <button type="button" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Upload Foto Selfie dengan
                                    KTP</label>
                                <div
                                    class="w-full h-32 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors cursor-pointer">
                                    <div class="w-8 h-8 bg-gray-300 rounded mb-2"></div>
                                    <p class="text-sm font-semibold text-gray-700">Selfie sambil memegang KTP</p>
                                    <p class="text-xs text-gray-400 mt-1">Drag & drop atau klik untuk browse</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 Form: Dokumen -->
                <div x-cloak x-show="step === 3" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Upload Dokumen</h2>
                    <p class="text-gray-500 text-sm mb-8">Dokumen pendukung untuk verifikasi bisnis Anda</p>

                    <div class="bg-gray-100/50 rounded-xl p-4 mb-6">
                        <p class="text-xs text-gray-600">Format file: JPG, PNG, PDF • Maksimal 5MB per file</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 py-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-6 h-6 rounded-full bg-gray-400 flex items-center justify-center text-white">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-800">Foto KTP Pemilik</span>
                            </div>
                            <span class="text-xs text-gray-500 font-medium">Uploaded</span>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 py-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-6 h-6 rounded-full bg-gray-400 flex items-center justify-center text-white">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-800">Sertifikasi Izin Usaha</span>
                            </div>
                            <span class="text-xs text-gray-500 font-medium">Uploaded</span>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-200 bg-gray-100"></div>
                                <span class="text-sm font-semibold text-gray-800">NPWP (Opsional)</span>
                            </div>
                            <button type="button"
                                class="px-3 py-1.5 border border-gray-200 rounded text-xs font-semibold text-gray-600 hover:bg-gray-50">Upload</button>
                        </div>

                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full border-2 border-gray-200 bg-gray-100"></div>
                                <span class="text-sm font-semibold text-gray-800">Foto Tempat Usaha</span>
                            </div>
                            <button type="button"
                                class="px-3 py-1.5 border border-gray-200 rounded text-xs font-semibold text-gray-600 hover:bg-gray-50">Upload</button>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <p class="text-xs text-gray-400">2 dari 4 dokumen telah diupload</p>
                    </div>
                </div>

                <!-- Step 4 Form: Rekening -->
                <div x-cloak x-show="step === 4" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Informasi Rekening Bank</h2>
                    <p class="text-gray-500 text-sm mb-8">Rekening untuk menerima pembayaran dari customer</p>

                    <div class="bg-gray-50 rounded-xl p-5 mb-8">
                        <h4 class="text-sm font-bold text-gray-900 mb-1">Penting</h4>
                        <p class="text-xs text-gray-600">Pastikan nama pemilik rekening sama dengan nama pemilik bisnis
                            yang
                            terdaftar.</p>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Bank <span
                                    class="text-red-500">*</span></label>
                            <input wire:model="bank_name" type="text"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all"
                                placeholder="BCA, Mandiri, BNI, BRI, dll">
                            @error('bank_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nomor Rekening <span
                                    class="text-red-500">*</span></label>
                            <input wire:model="bank_account_number" type="text"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all"
                                placeholder="1234567890">
                            <p class="mt-1.5 text-xs text-gray-400">Masukkan nomer rekening tanpa spasi atau tanda baca
                            </p>
                            @error('bank_account_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Pemilik Rekening <span
                                    class="text-red-500">*</span></label>
                            <input wire:model="bank_account_name" type="text"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all"
                                placeholder="Nama sesuai rekening bank">
                            <p class="mt-1.5 text-xs text-gray-400">Harus sama dengan nama pemilik bisnis</p>
                            @error('bank_account_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 5 Form: Review -->
                <div x-cloak x-show="step === 5" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Review Data</h2>
                    <p class="text-gray-500 text-sm mb-6">Pastikan semua data Anda sudah benar sebelum mengirim
                        permohonan
                        pendaftaran UMKM Anda.</p>

                    <div class="p-4 bg-yellow-50 text-yellow-800 rounded-lg text-sm mb-8 font-medium">
                        Pendaftaran UMKM Anda ini akan direview oleh Team Superadmin kami. Pastikan data yang Anda
                        berikan
                        otentik dan akurat.
                    </div>

                    <!-- Review Content Blocks -->
                    <div class="space-y-6">
                        <!-- section -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-bold text-gray-800">1. Informasi Bisnis</h3>
                                <button wire:click="$set('step', 1)"
                                    class="text-xs text-blue-600 font-semibold hover:underline">Edit</button>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 text-sm space-y-3">
                                <div class="grid grid-cols-3"><span class="text-gray-500">Nama Bisnis:</span><span
                                        class="col-span-2 font-medium" x-text="$wire.business_name || '-'"></span></div>
                                <div class="grid grid-cols-3"><span class="text-gray-500">Kategori:</span><span
                                        class="col-span-2 font-medium" x-text="$wire.business_category || '-'"></span>
                                </div>
                                <div class="grid grid-cols-3"><span class="text-gray-500">Alamat:</span><span
                                        class="col-span-2 font-medium" x-text="$wire.business_address || '-'"></span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-bold text-gray-800">2. Data Pemilik & Rekening</h3>
                                <button wire:click="$set('step', 2)"
                                    class="text-xs text-blue-600 font-semibold hover:underline">Edit</button>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 text-sm space-y-3">
                                <div class="grid grid-cols-3"><span class="text-gray-500">Nama Pemilik:</span><span
                                        class="col-span-2 font-medium" x-text="$wire.owner_name || '-'"></span></div>
                                <div class="grid grid-cols-3"><span class="text-gray-500">No Rekening:</span><span
                                        class="col-span-2 font-medium" x-text="$wire.bank_account_number || '-'"></span>
                                </div>
                                <div class="grid grid-cols-3"><span class="text-gray-500">Bank:</span><span
                                        class="col-span-2 font-medium" x-text="$wire.bank_name || '-'"></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="mt-12 pt-6 border-t border-gray-100 flex items-center justify-between">

                    <!-- Left Buttons -->
                    <div class="flex gap-3">
                        <button type="button" wire:click="previousStep" x-show="step > 1"
                            class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-sm font-bold hover:bg-gray-50 transition-colors">
                            Kembali
                        </button>
                        <button type="button" x-show="step < 5"
                            class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-sm font-bold hover:bg-gray-50 transition-colors">
                            Simpan Draft
                        </button>
                    </div>

                    <!-- Right Button -->
                    <button type="button" wire:click="nextStep" x-show="step < 5"
                        class="px-8 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-bold shadow-lg shadow-gray-900/20 hover:bg-gray-800 hover:shadow-gray-900/30 transition-all ml-auto">
                        Lanjut
                    </button>

                    <button type="button" wire:click="submit" x-cloak x-show="step === 5"
                        class="px-8 py-2.5 bg-green-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-green-600/20 hover:bg-green-700 hover:shadow-green-700/30 transition-all ml-auto">
                        Submit Permohonan
                    </button>

                </div>

            </div>
        </div>
    </div>