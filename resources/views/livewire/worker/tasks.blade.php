<div class="max-w-5xl mx-auto animate-fade-in">
    @if(!$selectedTask)
        {{-- List View --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900 font-plus tracking-tight mb-1">Tugas Saya</h1>
                <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">Daftar pekerjaan yang ditugaskan kepada Anda</p>
            </div>
            <div class="bg-gray-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest">
                {{ $tasks->count() }} Tugas Hari Ini
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white p-4 rounded-[28px] border border-gray-100 shadow-sm flex flex-wrap items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-2">
                <button wire:click="setFilter('upcoming')" @class([
                    'px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all',
                    'bg-[#2D2D2D] text-white shadow-lg shadow-gray-200' => $filter === 'upcoming',
                    'bg-gray-50 text-gray-400 hover:text-gray-900' => $filter !== 'upcoming'
                ])>Upcoming</button>
                <button wire:click="setFilter('hari-ini')" @class([
                    'px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all',
                    'bg-[#2D2D2D] text-white shadow-lg shadow-gray-200' => $filter === 'hari-ini',
                    'bg-gray-50 text-gray-400 hover:text-gray-900' => $filter !== 'hari-ini'
                ])>Hari Ini</button>
                <button wire:click="setFilter('in-progress')" @class([
                    'px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all',
                    'bg-[#2D2D2D] text-white shadow-lg shadow-gray-200' => $filter === 'in-progress',
                    'bg-gray-50 text-gray-400 hover:text-gray-900' => $filter !== 'in-progress'
                ])>In Progress</button>
                <button wire:click="setFilter('completed')" @class([
                    'px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all',
                    'bg-[#2D2D2D] text-white shadow-lg shadow-gray-200' => $filter === 'completed',
                    'bg-gray-50 text-gray-400 hover:text-gray-900' => $filter !== 'completed'
                ])>Completed</button>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Urutkan:</span>
                <select class="bg-transparent border-none text-[10px] font-black uppercase tracking-widest text-gray-900 focus:ring-0 cursor-pointer">
                    <option>Waktu terdekat</option>
                    <option>Status</option>
                </select>
            </div>
        </div>

        {{-- Task Cards --}}
        <div class="space-y-6">
            @forelse($tasks as $assignment)
                <div class="bg-white p-8 rounded-[40px] border border-gray-100 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">#{{ strtoupper(substr($assignment->order->invoice_number ?? 'ORD-'.$assignment->order->id, 0, 8)) }}</span>
                        <span @class([
                            'px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border',
                            'bg-blue-50 text-blue-600 border-blue-100' => $assignment->order->status === 'processing',
                            'bg-green-50 text-green-600 border-green-100' => $assignment->order->status === 'completed',
                            'bg-yellow-50 text-yellow-600 border-yellow-100' => $assignment->order->status === 'waiting_payment',
                        ])>
                            {{ str_replace('_', ' ', $assignment->order->status) }}
                        </span>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-2xl font-black text-gray-900 font-plus mb-2">{{ $assignment->order->customer_name ?? 'Ahmad Santoso' }}</h2>
                        <p class="text-sm font-bold text-gray-400">{{ $assignment->order->product->name }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $assignment->order->service_address ?? 'Jl. Gatot Subroto No. 10, Bandung' }}</p>
                                <a href="#" class="text-[10px] font-black text-blue-600 uppercase tracking-widest mt-1 inline-block">Lihat di Maps ↗</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ Carbon\Carbon::parse($assignment->order->booking_date)->format('d M Y') }}, {{ $assignment->order->booking_time ?? '10:00' }} WIB</p>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1 inline-block">Durasi: 4 jam</p>
                            </div>
                        </div>
                    </div>

                    @if($assignment->order->notes)
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 mb-8">
                        <p class="text-xs font-medium text-gray-500"><span class="font-black text-gray-900 mr-2 uppercase tracking-widest text-[10px]">Catatan:</span>{{ $assignment->order->notes }}</p>
                    </div>
                    @endif

                    <button wire:click="selectTask({{ $assignment->id }})" class="w-full py-4 bg-[#2D2D2D] hover:bg-black text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-gray-200">
                        @if($assignment->order->status === 'processing')
                            Lihat Detail & Update Progress
                        @else
                            Mulai Tugas
                        @endif
                    </button>
                </div>
            @empty
                <div class="bg-white py-20 rounded-[40px] border border-dashed border-gray-200 text-center flex flex-col items-center justify-center space-y-6">
                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="max-w-xs">
                        <h3 class="text-lg font-black text-gray-900 font-plus mb-2">Belum ada tugas yang ditugaskan</h3>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Tugas akan muncul di sini ketika admin telah melakukan penjadwalan untuk Anda.</p>
                    </div>
                </div>
            @endforelse
        </div>
    @else
        {{-- Detail View --}}
        <div class="space-y-8 animate-fade-in">
            <button wire:click="backToList" class="flex items-center gap-2 text-[10px] font-black text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-widest mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </button>

            <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3 mb-8">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">#{{ strtoupper(substr($selectedTask->order->invoice_number ?? 'ORD-'.$selectedTask->order->id, 0, 8)) }}</span>
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-blue-100">IN PROGRESS</span>
                </div>
                
                <h2 class="text-3xl font-black text-gray-900 font-plus mb-2">{{ $selectedTask->order->customer_name ?? 'Ahmad Santoso' }}</h2>
                <p class="text-sm font-bold text-gray-400 mb-8">{{ $selectedTask->order->product->name }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-gray-50">
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $selectedTask->order->service_address ?? 'Jl. Gatot Subroto No. 10, Bandung' }}</p>
                                <a href="#" class="text-[10px] font-black text-blue-600 uppercase tracking-widest mt-1 inline-block">Lihat di Maps ↗</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ Carbon\Carbon::parse($selectedTask->order->booking_date)->format('d M Y') }}, {{ $selectedTask->order->booking_time ?? '10:00' }} WIB (4 jam)</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 bg-gray-50 rounded-[32px] border border-gray-100">
                        <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mb-2">Instruksi Customer</p>
                        <p class="text-xs font-medium text-gray-500 leading-relaxed">{{ $selectedTask->order->notes ?? 'Customer request fokus ke area dapur dan kamar mandi.' }}</p>
                    </div>
                </div>
            </div>

            {{-- SOP Links --}}
            <div class="space-y-4">
                <h3 class="text-sm font-black text-gray-900 font-plus uppercase tracking-widest ml-2">SOP untuk Tugas ini</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('worker.sop') }}" class="p-6 bg-white rounded-[28px] border border-gray-100 shadow-sm flex items-center gap-4 hover:border-[#2D2D2D] transition-all group">
                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 group-hover:bg-[#2D2D2D] group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-xs font-black text-gray-900 font-plus">SOP Deep Cleaning</span>
                    </a>
                    <a href="{{ route('worker.sop') }}" class="p-6 bg-white rounded-[28px] border border-gray-100 shadow-sm flex items-center gap-4 hover:border-[#2D2D2D] transition-all group">
                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 group-hover:bg-[#2D2D2D] group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-black text-gray-900 font-plus">Safety Guidelines</span>
                    </a>
                </div>
            </div>

            {{-- Checklist --}}
            <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm">
                <h3 class="text-xl font-black text-gray-900 font-plus mb-8">Checklist Pekerjaan</h3>
                <div class="space-y-3">
                    @foreach($checklist as $index => $item)
                    <label class="flex items-center gap-4 p-5 bg-gray-50 rounded-[24px] border border-gray-100 cursor-pointer group hover:bg-white transition-all">
                        <input type="checkbox" wire:model="checklist.{{ $index }}.checked" class="sr-only peer">
                        <div class="w-6 h-6 bg-white border-2 border-gray-200 rounded-lg peer-checked:bg-[#2D2D2D] peer-checked:border-[#2D2D2D] transition-all flex items-center justify-center">
                            <svg class="w-4 h-4 text-white scale-0 peer-checked:scale-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-600 peer-checked:text-gray-900 peer-checked:line-through transition-all">{{ $item['label'] }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Update Progress Form --}}
            <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm space-y-10">
                <h3 class="text-xl font-black text-gray-900 font-plus">Update Progress & Laporan</h3>
                
                <div class="space-y-6">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Ringkasan Pekerjaan</label>
                        <textarea wire:model="summary" rows="4" class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-[28px] text-sm font-bold focus:ring-0 focus:border-[#2D2D2D] transition-all outline-none resize-none" placeholder="Tuliskan ringkasan atau kendala yang dihadapi..."></textarea>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Upload Foto Hasil Kerja (Before & After)</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="aspect-square bg-gray-50 rounded-[32px] border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-center cursor-pointer hover:border-[#2D2D2D] transition-all group">
                                <input type="file" multiple wire:model="photos" class="hidden">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-300 group-hover:bg-[#2D2D2D] group-hover:text-white transition-all shadow-sm mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-6">Upload Foto</span>
                            </label>
                            
                            @foreach($photos as $photo)
                            <div class="aspect-square bg-gray-100 rounded-[32px] overflow-hidden relative group">
                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                                <button class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="p-4 bg-green-50 border border-green-100 rounded-2xl text-green-600 text-xs font-bold uppercase tracking-widest">
                        {{ session('message') }}
                    </div>
                @endif

                <button 
                    wire:click="submitReport"
                    wire:loading.attr="disabled"
                    wire:target="photos"
                    class="w-full py-5 bg-[#2D2D2D] hover:bg-black text-white rounded-[24px] text-xs font-black uppercase tracking-widest transition-all shadow-xl shadow-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove wire:target="submitReport">Simpan Progress & Selesaikan Tugas</span>
                    <span wire:loading wire:target="submitReport">Sedang Mengirim...</span>
                </button>
            </div>
        </div>
    @endif
</div>
