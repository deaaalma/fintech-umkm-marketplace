@extends('layouts.customer')

@section('title', 'Messages')

@section('extra-styles')
    @media (min-width: 1024px) {
        .chat-layout {
            height: calc(100vh - 240px);
            min-height: 600px;
        }
    }
    .contact-card {
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid transparent;
    }
    .contact-card.active {
        background: white !important;
        box-shadow: 0 10px 30px -10px rgba(0, 11, 68, 0.08);
        border-color: rgba(0, 119, 182, 0.15) !important;
    }
    .message-bubble {
        max-width: 80%;
        border-radius: 2rem;
    }
    .message-sent {
        background: var(--brand-dark);
        color: white;
        border-bottom-right-radius: 0.5rem;
    }
    .message-received {
        background: white;
        color: var(--brand-dark);
        border-bottom-left-radius: 0.5rem;
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .chat-container::-webkit-scrollbar { width: 4px; }
    .chat-container::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
@endsection

@section('content')
@php
    $contacts = [
        [
            'id' => 1,
            'name' => 'Admin JOS',
            'role' => 'Principal Operations',
            'online' => true,
            'avatar' => 'AD',
            'color' => 'brand-primary',
            'chat_history' => [
                ['id' => 101, 'sender' => 'received', 'text' => 'Halo Ahmad! Ada yang bisa kami bantu terkait pesanan Anda?', 'time' => '09:00'],
                ['id' => 102, 'sender' => 'sent', 'text' => 'Halo Admin, saya ingin menanyakan tentang pesanan Deep Cleaning #BWP-0001.', 'time' => '09:05'],
                ['id' => 103, 'sender' => 'received', 'text' => 'Halo Ahmad, Pre-invoice sudah kami kirim ya. Bisa dicek di menu Orders.', 'time' => '10:15'],
            ]
        ],
        [
            'id' => 2,
            'name' => 'BWP Cleaning Support',
            'role' => 'Vendor Partner',
            'online' => true,
            'avatar' => 'BW',
            'color' => 'brand-dark',
            'chat_history' => [
                ['id' => 201, 'sender' => 'received', 'text' => 'Selamat siang Pak Ahmad, tim kami sudah siap berangkat besok.', 'time' => '14:00'],
                ['id' => 202, 'sender' => 'sent', 'text' => 'Oke, pastikan bawa peralatan lengkap ya.', 'time' => '14:10'],
                ['id' => 203, 'sender' => 'received', 'text' => 'Tentu Pak, peralatan vacuum dan disinfectant sudah ready.', 'time' => '14:15'],
            ]
        ],
        [
            'id' => 3,
            'name' => 'Tech Solutions JOS',
            'role' => 'Development Team',
            'online' => false,
            'avatar' => 'TS',
            'color' => 'brand-cyan',
            'chat_history' => [
                ['id' => 301, 'sender' => 'received', 'text' => 'Update progress: UI Design E-commerce sudah mencapai 80%.', 'time' => 'Yesterday'],
                ['id' => 302, 'sender' => 'received', 'text' => 'Silakan cek file mockup yang kami kirim di dashboard.', 'time' => 'Yesterday'],
            ]
        ]
    ];
@endphp

<div class="max-w-6xl mx-auto px-6 lg:px-8 h-full" x-data="{ 
    activeId: 1,
    newMessage: '',
    contacts: @js($contacts),
    get activeChat() {
        return this.contacts.find(c => c.id === this.activeId);
    },
    sendMessage() {
        if (this.newMessage.trim() === '') return;
        const now = new Date();
        const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
        
        this.activeChat.chat_history.push({
            id: Date.now(),
            sender: 'sent',
            text: this.newMessage,
            time: time
        });
        this.newMessage = '';
        this.$nextTick(() => {
            const container = document.getElementById('chat-container');
            container.scrollTop = container.scrollHeight;
        });
    }
}">
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 chat-layout">
        <!-- Sidebar Contacts -->
        <div class="w-full lg:w-1/3 flex flex-col gap-4 lg:gap-6 min-h-[300px] lg:h-full">
            <div class="space-y-2 animate-on-load">
                <h1 class="text-4xl font-bold text-brand-dark tracking-tighter">Messages</h1>
                <p class="text-slate-400 text-xs font-black uppercase tracking-widest">Connect with our support team</p>
            </div>
            
            <div class="premium-card flex-grow overflow-hidden flex flex-col p-4 animate-on-load">
                <div class="relative mb-6 px-2">
                    <input type="text" placeholder="Search conversations..." class="w-full bg-slate-50 border-none rounded-2xl py-4 pl-12 pr-4 text-sm font-semibold text-brand-dark placeholder:text-slate-300 focus:ring-2 focus:ring-brand-primary/20 transition-all">
                    <svg class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                </div>
                
                <div class="flex-grow overflow-y-auto space-y-2 pr-2 chat-container">
                    <template x-for="contact in contacts" :key="contact.id">
                        <div @click="activeId = contact.id" 
                             :class="activeId === contact.id ? 'active' : 'hover:bg-slate-50 border-transparent bg-slate-50/30'"
                             class="contact-card p-5 rounded-3xl border flex items-center gap-4 cursor-pointer relative group">
                            <div class="relative flex-shrink-0">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-brand-dark font-black text-xs shadow-sm group-hover:scale-105 transition-transform"
                                     x-text="contact.avatar">
                                </div>
                                <div x-show="contact.online" class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-green-500 border-4 border-white"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-bold text-brand-dark truncate" x-text="contact.name"></h4>
                                </div>
                                <p class="text-[11px] text-slate-400 truncate font-medium" x-text="contact.role"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Chat Window -->
        <div class="w-full lg:flex-1 flex flex-col min-h-[500px] lg:h-full animate-on-load">
            <div class="premium-card flex-grow flex flex-col overflow-hidden">
                <!-- Chat Header -->
                <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-white/50 backdrop-blur-sm relative z-10 transition-all duration-500">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-black text-xs shadow-sm shadow-brand-primary/5 transition-all"
                             :class="'bg-[#F0FAFC] text-' + activeChat.color"
                             x-text="activeChat.avatar">
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xl font-black text-brand-dark tracking-tight" x-text="activeChat.name"></h3>
                                <div x-show="activeChat.online" class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest" x-text="activeChat.role + (activeChat.online ? ' • Online' : ' • Offline')"></p>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                <div id="chat-container" class="flex-grow overflow-y-auto p-8 space-y-6 bg-slate-50/30 chat-container">
                    <template x-for="msg in activeChat.chat_history" :key="msg.id">
                        <div :class="msg.sender === 'sent' ? 'flex-row-reverse' : ''" class="flex items-end gap-3 translate-y-0 opacity-100 transition-all duration-500">
                            <div :class="msg.sender === 'sent' ? 'message-sent shadow-xl shadow-brand-dark/10' : 'message-received shadow-sm'" 
                                 class="message-bubble px-6 py-4 relative">
                                <p class="text-[13px] font-medium leading-relaxed" x-text="msg.text"></p>
                                <span :class="msg.sender === 'sent' ? 'text-white/40' : 'text-slate-300'" 
                                      class="text-[9px] font-black absolute -top-5 right-0 uppercase tracking-widest" 
                                      x-text="msg.time"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Input Area -->
                <div class="p-8 bg-white border-t border-slate-50 relative z-10">
                    <form @submit.prevent="sendMessage()" class="relative">
                        <input type="text" 
                               x-model="newMessage"
                               placeholder="Type your message here..." 
                               class="w-full bg-[#f8fbff] border-none rounded-[2rem] py-6 pl-8 pr-24 text-sm font-semibold text-brand-dark placeholder:text-slate-400 focus:ring-2 focus:ring-brand-primary/10 transition-all shadow-inner">
                        
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center gap-2">
                            <button type="submit" 
                                    class="w-12 h-12 rounded-2xl bg-brand-dark text-white flex items-center justify-center hover:bg-brand-primary shadow-xl shadow-brand-dark/20 transition-all active:scale-95 group">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"><line x1="22" y1="2" x2="11" y2="13"/><polyline points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
