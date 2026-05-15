
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
                                <input wire:model="business_phone" type="number"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
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
                            <input wire:model="owner_nik" type="number"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
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
                                <input type="file" wire:model="owner_ktp_photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 border border-gray-300 rounded-xl cursor-pointer">
                                <div wire:loading wire:target="owner_ktp_photo" class="text-xs text-gray-500 mt-1">Uploading...</div>
                                @if ($owner_ktp_photo)
                                    <p class="text-xs text-green-600 mt-1">File uploaded: {{ $owner_ktp_photo->getClientOriginalName() }}</p>
                                @endif
                                @error('owner_ktp_photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Upload Foto Selfie dengan KTP</label>
                                <input type="file" wire:model="owner_selfie_photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 border border-gray-300 rounded-xl cursor-pointer">
                                <div wire:loading wire:target="owner_selfie_photo" class="text-xs text-gray-500 mt-1">Uploading...</div>
                                @if ($owner_selfie_photo)
                                    <p class="text-xs text-green-600 mt-1">File uploaded: {{ $owner_selfie_photo->getClientOriginalName() }}</p>
                                @endif
                                @error('owner_selfie_photo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
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
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Foto KTP Pemilik <span class="text-red-500">*</span></label>
                            <input type="file" wire:model="document_ktp" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 border border-gray-300 rounded-xl cursor-pointer">
                            <div wire:loading wire:target="document_ktp" class="text-xs text-gray-500 mt-1">Uploading...</div>
                            @if ($document_ktp) <p class="text-xs text-green-600 mt-1">File uploaded: {{ $document_ktp->getClientOriginalName() }}</p> @endif
                            @error('document_ktp') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Sertifikasi Izin Usaha <span class="text-red-500">*</span></label>
                            <input type="file" wire:model="document_certificate" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 border border-gray-300 rounded-xl cursor-pointer">
                            <div wire:loading wire:target="document_certificate" class="text-xs text-gray-500 mt-1">Uploading...</div>
                            @if ($document_certificate) <p class="text-xs text-green-600 mt-1">File uploaded: {{ $document_certificate->getClientOriginalName() }}</p> @endif
                            @error('document_certificate') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">NPWP (Opsional)</label>
                            <input type="file" wire:model="document_npwp" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 border border-gray-300 rounded-xl cursor-pointer">
                            <div wire:loading wire:target="document_npwp" class="text-xs text-gray-500 mt-1">Uploading...</div>
                            @if ($document_npwp) <p class="text-xs text-green-600 mt-1">File uploaded: {{ $document_npwp->getClientOriginalName() }}</p> @endif
                            @error('document_npwp') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Foto Tempat Usaha <span class="text-red-500">*</span></label>
                            <input type="file" wire:model="document_place" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 border border-gray-300 rounded-xl cursor-pointer">
                            <div wire:loading wire:target="document_place" class="text-xs text-gray-500 mt-1">Uploading...</div>
                            @if ($document_place) <p class="text-xs text-green-600 mt-1">File uploaded: {{ $document_place->getClientOriginalName() }}</p> @endif
                            @error('document_place') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
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
                            <input wire:model="bank_account_number" type="number"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-black focus:border-black text-sm transition-all [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
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