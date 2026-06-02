<div class="min-h-screen" x-data="{ activeTab: @entangle('activeTab') }">
    <div class="w-full bg-white border-b border-[#e5e5e5]">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-4">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('superadmin.dashboard') }}" class="text-[#666666] hover:text-[#0078b7] transition-colors" style="font-family: 'Figtree', sans-serif;">Dashboard</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#999999]">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span class="text-[#003d5c] font-medium" style="font-family: 'Figtree', sans-serif;">Pengaturan Platform</span>
            </div>
        </div>
    </div>

    <div class="w-full bg-white border-b border-[#e5e5e5]">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8 py-8">
            <h1 class="text-[32px] leading-tight font-normal text-[#003d5c] tracking-tight mb-2" style="font-weight: 400; font-family: 'Figtree', sans-serif;">Pengaturan Platform</h1>
            <p class="text-sm text-[#666666]" style="font-family: 'Figtree', sans-serif;">Konfigurasi dan pengaturan sistem platform UMKM</p>
        </div>
    </div>

    <div class="w-full bg-gradient-to-br from-background via-background to-[#0078b7]/5 py-12">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
            <div class="bg-white rounded-t-3xl border border-[#e5e5e5] border-b-0">
                <div class="flex flex-wrap items-center gap-6 px-8 pt-6 border-b border-[#e5e5e5]">
                    @foreach(['umum' => 'Umum', 'komisi' => 'Komisi', 'payment' => 'Payment', 'email' => 'Email', 'lainnya' => 'Lainnya'] as $key => $label)
                        <button 
                            @click="activeTab = '{{ $key }}'"
                            :class="activeTab === '{{ $key }}' ? 'text-[#0078b7] border-[#0078b7]' : 'text-[#666666] border-transparent hover:text-[#0078b7]'"
                            class="pb-4 px-2 text-sm font-medium border-b-2 transition-all duration-200 whitespace-nowrap"
                            style="font-family: 'Figtree', sans-serif;">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <form wire:submit.prevent="saveSettings" class="bg-white rounded-b-3xl border border-[#e5e5e5] border-t-0 p-8">
                
                @if (session()->has('message'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span class="text-sm font-medium" style="font-family: 'Figtree', sans-serif;">{{ session('message') }}</span>
                    </div>
                @endif

                @php 
                    $labelClass = "block text-xs font-semibold text-[#999999] uppercase mb-2";
                    $inputClass = "w-full px-4 py-3 rounded-lg border border-[#e5e5e5] focus:outline-none focus:ring-2 focus:ring-[#0078b7] text-sm";
                @endphp

                <div x-show="activeTab === 'umum'" class="space-y-8" x-cloak>
                    <div>
                        <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Platform Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">PLATFORM NAME</label>
                                <input type="text" wire:model="platformName" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">TAGLINE</label>
                                <input type="text" wire:model="platformTagline" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">TIMEZONE</label>
                                <select wire:model="timezone" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                                    <option value="Asia/Jakarta">Asia/Jakarta (GMT+7)</option>
                                    <option value="Asia/Makassar">Asia/Makassar (GMT+8)</option>
                                    <option value="Asia/Jayapura">Asia/Jayapura (GMT+9)</option>
                                </select>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">CURRENCY</label>
                                <select wire:model="currency" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                                    <option value="IDR">IDR (Indonesian Rupiah)</option>
                                    <option value="USD">USD (US Dollar)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-[#e5e5e5]">
                        <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Business Hours</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">OPENING TIME</label>
                                <input type="time" wire:model="openingTime" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">CLOSING TIME</label>
                                <input type="time" wire:model="closingTime" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-[#e5e5e5]">
                        <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Maintenance Mode</h3>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                            <div>
                                <p class="text-sm font-semibold text-[#003d5c] mb-1" style="font-family: 'Figtree', sans-serif;">Enable Maintenance Mode</p>
                                <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">Platform akan ditutup sementara untuk maintenance</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="isMaintenance" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'komisi'" class="space-y-8" x-cloak>
                    <div>
                        <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Commission Settings</h3>
                        <p class="text-sm text-[#666666] mb-6" style="font-family: 'Figtree', sans-serif;">Atur persentase komisi platform untuk setiap transaksi</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">Default Commission Rate (%)</label>
                                <input type="number" wire:model="commissionRate" min="0" max="100" step="0.1" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                                <p class="text-xs text-[#666666] mt-2" style="font-family: 'Figtree', sans-serif;">Komisi default untuk semua kategori</p>
                            </div>
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">Minimum Transaction Fee (Rp)</label>
                                <input type="number" wire:model="minimumFee" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                                <p class="text-xs text-[#666666] mt-2" style="font-family: 'Figtree', sans-serif;">Fee minimum untuk transaksi kecil</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'payment'" class="space-y-8" x-cloak>
                    <div>
                        <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Payment Methods</h3>
                        <p class="text-sm text-[#666666] mb-6" style="font-family: 'Figtree', sans-serif;">Kelola metode pembayaran yang tersedia</p>
                        
                        <div class="space-y-4">
                            @php
                                $paymentMethods = [
                                    ['id' => 'bank', 'name' => 'Transfer Bank', 'desc' => 'BCA, Mandiri, BNI, BRI', 'icon' => '<rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line>', 'color' => 'blue'],
                                    ['id' => 'ewallet', 'name' => 'E-Wallet', 'desc' => 'GoPay, OVO, DANA, ShopeePay', 'icon' => '<rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line>', 'color' => 'purple'],
                                    ['id' => 'cash', 'name' => 'Cash', 'desc' => 'Pembayaran tunai', 'icon' => '<line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>', 'color' => 'green'],
                                ];
                            @endphp

                            @foreach($paymentMethods as $method)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-{{ $method['color'] }}-100 rounded-lg flex items-center justify-center text-{{ $method['color'] }}-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $method['icon'] !!}</svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-[#003d5c]" style="font-family: 'Figtree', sans-serif;">{{ $method['name'] }}</p>
                                        <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">{{ $method['desc'] }}</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="activePayments.{{ $method['id'] }}" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'email'" class="space-y-8" x-cloak>
                    <div>
                        <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Email Configuration</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">SMTP Host</label>
                                <input type="text" wire:model="smtpHost" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">SMTP Port</label>
                                <input type="text" wire:model="smtpPort" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">From Email</label>
                                <input type="email" wire:model="fromEmail" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                            </div>
                            <div>
                                <label class="{{ $labelClass }}" style="font-family: 'Figtree', sans-serif;">From Name</label>
                                <input type="text" wire:model="fromName" class="{{ $inputClass }}" style="font-family: 'Figtree', sans-serif;">
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'lainnya'" class="space-y-8" x-cloak>
                    <div>
                        <h3 class="text-lg font-semibold text-[#003d5c] mb-6" style="font-family: 'Figtree', sans-serif;">Other Settings</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                <div>
                                    <p class="text-sm font-semibold text-[#003d5c] mb-1" style="font-family: 'Figtree', sans-serif;">Enable User Registration</p>
                                    <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">Izinkan pengguna baru mendaftar</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="enableRegistration" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                <div>
                                    <p class="text-sm font-semibold text-[#003d5c] mb-1" style="font-family: 'Figtree', sans-serif;">Email Verification Required</p>
                                    <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">Wajibkan verifikasi email untuk pengguna baru</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="requireEmailVerification" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-[#e5e5e5]">
                                <div>
                                    <p class="text-sm font-semibold text-[#003d5c] mb-1" style="font-family: 'Figtree', sans-serif;">Enable Review System</p>
                                    <p class="text-xs text-[#666666]" style="font-family: 'Figtree', sans-serif;">Izinkan customer memberikan review</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="enableReviews" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#0078b7]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0078b7]"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-[#e5e5e5] flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-[#003d5c] text-white rounded-xl hover:bg-[#0078b7] transition-colors font-semibold flex items-center gap-2" style="font-family: 'Figtree', sans-serif;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        <span wire:loading.remove wire:target="saveSettings">Save Settings</span>
                        <span wire:loading wire:target="saveSettings">Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>