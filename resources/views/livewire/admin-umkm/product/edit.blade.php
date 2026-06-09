<x-slot:title>Edit Layanan</x-slot>

<div class="space-y-6 pb-24 relative">
    {{-- Breadcrumbs & Header --}}
    <div>

        
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Layanan</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Perbarui detail layanan Anda di bawah ini.</p>
        </div>
    </div>

    {{-- Form Sections --}}
    <form wire:submit.prevent="save" class="space-y-6">
        
        {{-- 1. Informasi Utama --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Utama</h2>
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Nama Layanan *</label>
                    <input type="text" wire:model="name" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-all">
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
                    <div id="quill-editor" class="bg-white border-x border-b border-gray-200 rounded-b-xl min-h-[250px] text-sm">
                        {!! $description !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Harga & Durasi --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Harga & Durasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Harga Estimasi *</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold text-sm pointer-events-none">Rp</span>
                        <input type="number" wire:model="price" class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-all">
                    </div>
                    @error('price') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-2">Estimasi Durasi (Menit)</label>
                    <input type="number" wire:model="duration_minutes" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-black focus:border-black transition-all">
                    @error('duration_minutes') <span class="text-red-500 text-xs font-medium">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- 4. Upload Gambar --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Thumbnail Layanan</h2>
            
            <div class="mt-1 flex items-center gap-6">
                @if($thumbnail)
                    <div class="relative w-32 h-32 rounded-2xl overflow-hidden border border-gray-200">
                        <img src="{{ $thumbnail->temporaryUrl() }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <span class="text-[10px] text-white font-bold uppercase tracking-widest">Preview Baru</span>
                        </div>
                    </div>
                @elseif($existingThumbnail)
                    <div class="relative w-32 h-32 rounded-2xl overflow-hidden border border-gray-200">
                        <img src="{{ Storage::url($existingThumbnail) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <span class="text-[10px] text-white font-bold uppercase tracking-widest">Thumbnail Saat Ini</span>
                        </div>
                    </div>
                @else
                    <div class="w-32 h-32 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif

                <div class="flex-1">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Ganti Gambar</label>
                    <input type="file" wire:model="thumbnail" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-all cursor-pointer">
                    <p class="text-[10px] text-gray-400 font-medium mt-2">JPG, PNG, maksimal 2MB. Kosongkan jika tidak ingin mengganti.</p>
                </div>
            </div>
            @error('thumbnail') <span class="text-red-500 text-xs font-medium mt-2 block">{{ $message }}</span> @enderror
        </div>

        {{-- 7. Status & Visibilitas --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Status & Visibilitas</h2>
            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-xl bg-gray-50/50">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Tampilkan di Website</h3>
                    <p class="text-[11px] text-gray-500 font-medium mt-0.5">Jika aktif, pelanggan dapat melihat dan memesan layanan ini.</p>
                </div>
                <button type="button" wire:click="$toggle('is_active')" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none {{ $is_active ? 'bg-[#2D2D2D]' : 'bg-gray-200' }}">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                </button>
            </div>
        </div>

        {{-- Sticky Bottom Action Bar --}}
        <div class="fixed bottom-0 left-0 lg:left-72 right-0 bg-white border-t border-gray-200 p-4 md:px-8 z-40 shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)]">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="hidden md:block">
                    <p class="text-xs text-gray-500 font-medium">Pastikan semua data sudah terisi dengan benar.</p>
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <a href="{{ route('umkm.services') }}" class="flex-1 md:flex-none px-6 py-2.5 border border-gray-200 rounded-full text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 md:flex-none px-8 py-2.5 bg-[#2D2D2D] hover:bg-black text-white rounded-full text-sm font-bold shadow-sm transition-all flex items-center justify-center gap-2">
                        <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- Quill JS --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                ['clean']
            ];

            var quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Tulis deskripsi lengkap layanan di sini...',
                modules: {
                    toolbar: toolbarOptions
                }
            });

            document.querySelector('.ql-toolbar').classList.add('rounded-t-xl', 'border-gray-200', 'bg-gray-50');
            
            quill.on('text-change', function() {
                @this.set('description', quill.root.innerHTML);
            });
        });
    </script>
</div>
