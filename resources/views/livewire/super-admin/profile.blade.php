<div class="max-w-4xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Header Section -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 bg-[#000B44] rounded-full flex items-center justify-center border-4 border-slate-50 shadow-lg transition-transform hover:scale-105">
                <span class="text-white text-2xl font-black">{{ substr($name, 0, 1) }}</span>
            </div>
            <div class="space-y-0.5">
                <h2 class="text-2xl font-black text-[#000B44] font-plus tracking-tight">{{ auth()->user()->name }}</h2>
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-[#0077B6] bg-[#0077B6]/10 px-2 py-0.5 rounded-full uppercase tracking-widest">Superadmin</span>
                </div>
            </div>
        </div>
        
        @if($isEditing)
            <div class="flex items-center gap-2">
                <button wire:click="toggleEdit" class="px-5 py-2.5 bg-slate-50 text-slate-400 rounded-xl font-bold text-xs hover:bg-slate-100 transition-all">Cancel</button>
                <button wire:click="updateProfile" wire:loading.attr="disabled" class="px-6 py-3 bg-[#0077B6] text-white rounded-xl font-black text-sm shadow-lg shadow-[#0077B6]/20 hover:bg-[#000B44] transition-all flex items-center gap-2">
                    <span wire:loading.remove>Save Changes</span>
                    <span wire:loading>Saving...</span>
                </button>
            </div>
        @else
            <button wire:click="toggleEdit" class="w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-[#0077B6] hover:bg-slate-50 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </button>
        @endif
    </div>

    <!-- Personal Information Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-4 border-b border-slate-50 flex items-center justify-between bg-white">
            <h3 class="text-[11px] font-black text-[#000B44] font-plus uppercase tracking-[0.2em]">Personal Credentials</h3>
            @if(session()->has('success'))
                <span class="text-[10px] font-bold text-green-500 bg-green-50 px-3 py-1 rounded-lg animate-fade-in">✓ Success</span>
            @endif
        </div>
        <div class="px-8 pt-4 pb-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
            <div class="space-y-0.5">
                <label class="text-[12px] font-black text-slate-500 uppercase tracking-widest">Profile Alias</label>
                @if($isEditing)
                    <input wire:model="name" type="text" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl p-3 text-[15px] font-bold text-[#000B44] focus:border-[#0077B6] focus:ring-0 transition-all">
                @else
                    <p class="text-[15px] font-bold text-[#000B44] font-plus tracking-tight capitalize leading-tight">{{ auth()->user()->name }}</p>
                @endif
            </div>
            <div class="space-y-0.5">
                <label class="text-[12px] font-black text-slate-500 uppercase tracking-widest">System Privilege</label>
                <p class="text-[15px] font-black text-[#0077B6] uppercase tracking-wide leading-tight">Super Administrator</p>
            </div>
            <div class="space-y-0.5">
                <label class="text-[12px] font-black text-slate-500 uppercase tracking-widest">Email Secure</label>
                @if($isEditing)
                    <input wire:model="email" type="email" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl p-3 text-[15px] font-bold text-[#000B44] focus:border-[#0077B6] focus:ring-0 transition-all">
                @else
                    <p class="text-[15px] font-bold text-[#000B44] font-plus tracking-tight leading-tight">{{ auth()->user()->email }}</p>
                @endif
            </div>
            <div class="space-y-0.5">
                <label class="text-[12px] font-black text-slate-500 uppercase tracking-widest">Communication</label>
                @if($isEditing)
                    <input wire:model="phone" type="text" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl p-3 text-[15px] font-bold text-[#000B44] focus:border-[#0077B6] focus:ring-0 transition-all">
                @else
                    <p class="text-[15px] font-bold text-[#000B44] font-plus tracking-tight leading-tight">{{ auth()->user()->phone ?? '-' }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
