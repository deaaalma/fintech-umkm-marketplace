<x-slot:title>Tambah Layanan</x-slot>

<div class="space-y-6 pb-24 relative animate-fade-in-up">
    {{-- Breadcrumbs & Header --}}
    <div>

        
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Layanan</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Isi detail di bawah untuk menambahkan layanan baru. Kolom dengan tanda * wajib diisi.</p>
        </div>
    </div>

    {{-- Form Sections --}}
    <form class="space-y-6">
        
        {{-- 1. Informasi Utama --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Utama</h2>
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Nama Layanan *</label>
                    <input type="text" wire:model="name" placeholder="Contoh: Deep Cleaning Rumah" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm placeholder-slate-400 focus:ring-black focus:border-black transition-all">
                    @error('name') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Kategori *</label>
                    <select wire:model="type" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-all">
                        <option value="">Pilih Kategori</option>
                        <option value="Service">Service</option>
                        <option value="Product">Product</option>
                    </select>
                    @error('type') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- 2. Deskripsi Lengkap --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Deskripsi Lengkap</h2>
            <div>
                <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Konten Deskripsi</label>
                <div wire:ignore>
                    <div id="quill-editor" class="bg-white border-x border-b border-gray-200 rounded-b-xl min-h-[250px] text-sm"></div>
                </div>
                <p class="text-[10px] text-gray-400 font-medium mt-2">Jelaskan layanan Anda secara detail. Ini akan ditampilkan di halaman detail layanan.</p>
            </div>
        </div>

        {{-- 3. Harga & Durasi --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Harga & Durasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Harga (Mulai Dari) *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold text-sm pointer-events-none">Rp</span>
                        <input type="number" wire:model="price" placeholder="50.000" class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm placeholder-slate-400 focus:ring-black focus:border-black transition-all">
                    </div>
                    @error('price') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Kategori Satuan *</label>
                    <input type="text" wire:model="unit_type" placeholder="/m2, /jam, /ruangan..." class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm placeholder-slate-400 focus:ring-black focus:border-black transition-all">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Estimasi Durasi Pengerjaan</label>
                    <div class="flex gap-3">
                        <input type="number" wire:model="duration_value" placeholder="1" class="w-24 px-4 py-3 border border-gray-200 rounded-xl text-sm placeholder-slate-400 focus:ring-black focus:border-black transition-all">
                        <select wire:model="duration_unit" class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:ring-black focus:border-black transition-all">
                            <option value="menit">Menit</option>
                            <option value="jam">Jam</option>
                            <option value="hari">Hari</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Upload Gambar --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Upload Gambar</h2>
            
            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:bg-gray-50 transition-all group relative cursor-pointer mb-6"
                 onclick="document.getElementById('image-upload').click()">
                <div wire:loading wire:target="images" class="absolute inset-0 bg-white/80 flex items-center justify-center z-10 rounded-2xl">
                    <span class="text-sm font-bold text-gray-900">Uploading...</span>
                </div>
                <svg class="w-10 h-10 mx-auto text-gray-400 group-hover:text-black mb-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <p class="text-sm font-bold text-gray-900">Drag & Drop gambar Anda di sini</p>
                <p class="text-xs text-gray-500 font-medium mt-1">Atau klik untuk browse</p>
                <p class="text-[10px] text-gray-400 font-medium mt-4">JPG, PNG, maksimal 2MB per gambar. (Max 3)</p>
                <input type="file" id="image-upload" wire:model="images" multiple accept="image/*" class="hidden">
            </div>

            <div class="grid grid-cols-3 gap-4">
                @for($i = 0; $i < 3; $i++)
                    @if(isset($imagePreviews[$i]))
                    <div class="relative rounded-xl border border-gray-200 aspect-video overflow-hidden group">
                        <img src="{{ $imagePreviews[$i]->temporaryUrl() }}" class="w-full h-full object-cover">
                        <button type="button" wire:click="removeImage({{ $i }})" class="absolute top-2 right-2 w-6 h-6 bg-white rounded-md shadow-sm flex items-center justify-center text-red-500 hover:bg-red-50 transition-all opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        @if($i == 0)
                        <span class="absolute bottom-2 left-2 px-2 py-1 bg-black/70 text-white text-[10px] font-bold rounded">Thumbnail Utama</span>
                        @endif
                    </div>
                    @else
                    <div class="rounded-xl border-2 border-dashed border-gray-200 aspect-video flex flex-col items-center justify-center text-gray-400 bg-gray-50/50">
                        <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-xs font-medium">Slot {{ $i + 1 }}</span>
                    </div>
                    @endif
                @endfor
            </div>
            <p class="text-[10px] text-gray-400 font-medium mt-4">Gambar pertama akan digunakan sebagai thumbnail utama di list layanan Anda.</p>
        </div>

        {{-- 5. Apa Yang Termasuk --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-900">Apa Yang Termasuk</h2>
                <button type="button" wire:click="addFeature" class="text-xs font-bold text-[#0077B6] hover:text-blue-800 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Item
                </button>
            </div>
            
            <div class="space-y-3">
                @foreach($features as $index => $feature)
                <div class="flex items-center gap-3">
                    <input type="text" wire:model="features.{{ $index }}" placeholder="Contoh: Pembersihan debu & vakum karpet" class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm placeholder-slate-400 focus:ring-black focus:border-black transition-all">
                    <button type="button" wire:click="removeFeature({{ $index }})" class="p-3 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" {{ count($features) == 1 ? 'disabled' : '' }}>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
                @endforeach
            </div>
            <p class="text-[10px] text-gray-400 font-medium mt-4">Jelaskan secara detail apa saja yang didapatkan pelanggan saat memesan layanan ini.</p>
        </div>

        {{-- 6. Syarat & Ketentuan --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Syarat & Ketentuan</h2>
            <textarea wire:model="terms" rows="4" placeholder="Contoh:&#10;- Minimal durasi booking 2 jam.&#10;- Pembatalan maksimal 24 jam sebelum jadwal." class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm placeholder-slate-400 focus:ring-black focus:border-black transition-all"></textarea>
            <p class="text-[10px] text-gray-400 font-medium mt-2">Syarat dan ketentuan khusus untuk layanan ini.</p>
        </div>

        {{-- 7. Status & Visibilitas --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Status & Visibilitas</h2>
            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl bg-gray-50/50">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Tampilkan di Website</h3>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">Jika aktif, pelanggan dapat melihat dan memesan layanan ini.</p>
                </div>
                <button type="button" wire:click="$toggle('is_active')" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none {{ $is_active ? 'bg-[#000B44]' : 'bg-gray-200' }}">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                </button>
            </div>
        </div>
    </form>

    {{-- Sticky Bottom Action Bar --}}
    <div class="fixed bottom-0 left-0 lg:left-72 right-0 bg-white border-t border-gray-200 p-4 md:px-8 z-40 shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)]">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="hidden md:block">
                <p class="text-xs text-gray-500 font-medium">Pastikan semua data sudah terisi dengan benar.</p>
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <button type="button" wire:click="saveAsDraft" class="flex-1 md:flex-none px-6 py-2.5 border border-gray-200 rounded-full text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition-all">
                    Simpan Draft
                </button>
                <button type="button" wire:click="save" class="flex-1 md:flex-none px-8 py-2.5 bg-[#000B44] hover:bg-[#000066] text-white rounded-full text-sm font-bold shadow-sm transition-all flex items-center justify-center gap-2">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Publish Layanan
                </button>
            </div>
        </div>
    </div>

    {{-- Quill JS --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],
                [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'direction': 'rtl' }],                         // text direction
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'align': [] }],
                ['clean']                                         // remove formatting button
            ];

            var quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Tulis deskripsi lengkap layanan di sini...',
                modules: {
                    toolbar: toolbarOptions
                }
            });

            // Styling toolbar biar match sama tailwind
            document.querySelector('.ql-toolbar').classList.add('rounded-t-xl', 'border-gray-200', 'bg-gray-50');
            
            quill.on('text-change', function() {
                @this.set('description', quill.root.innerHTML);
            });
        });
    </script>
</div>
