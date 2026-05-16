@extends('layouts.customer')

@section('title', 'Notifications')

@section('extra-styles')
    .notification-item {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .notification-item:hover {
        transform: translateX(8px);
        background: white;
        box-shadow: 0 20px 40px -10px rgba(0, 11, 68, 0.05);
    }
    .unread-dot {
        box-shadow: 0 0 15px rgba(0, 180, 216, 0.5);
    }
@endsection

@section('content')
@php
    $notifications = [
        [
            'id' => 1,
            'type' => 'order',
            'title' => 'Pre-Invoice Ready',
            'message' => 'Admin has sent a pre-invoice for your "Deep Cleaning Service" order #BWP-0001. Please review and proceed to payment.',
            'time' => '10 min ago',
            'is_unread' => true,
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
            'color' => 'brand-primary'
        ],
        [
            'id' => 2,
            'type' => 'status',
            'title' => 'Payment Confirmed',
            'message' => 'Great news! Your payment for "E-Commerce Development" has been verified. Our team is starting the development phase.',
            'time' => '2 hours ago',
            'is_unread' => true,
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
            'color' => 'brand-dark'
        ],
        [
            'id' => 3,
            'type' => 'system',
            'title' => 'Security Update',
            'message' => 'Your account password was successfully changed. If you did not perform this action, please contact support immediately.',
            'time' => 'Yesterday',
            'is_unread' => false,
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
            'color' => 'slate-400'
        ],
        [
            'id' => 4,
            'type' => 'promo',
            'title' => 'Special Weekend Offer!',
            'message' => 'Get 20% discount on all cleaning services this weekend only. Use code: CLEANJOS20.',
            'time' => '2 days ago',
            'is_unread' => false,
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>',
            'color' => 'brand-cyan'
        ],
        [
            'id' => 5,
            'type' => 'order',
            'title' => 'Order Completed',
            'message' => 'Your order "Office Maintenance" #BWP-0012 has been marked as completed. Don\'t forget to leave a review!',
            'time' => '3 days ago',
            'is_unread' => false,
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>',
            'color' => 'brand-dark'
        ]
    ];
@endphp

<div class="max-w-4xl mx-auto px-6" x-data="{ 
    activeTab: 'all',
    notifications: @js($notifications),
    get unreadCount() {
        return this.notifications.filter(n => n.is_unread).length;
    },
    get filteredNotifications() {
        if (this.activeTab === 'all') return this.notifications;
        if (this.activeTab === 'unread') return this.notifications.filter(n => n.is_unread);
        if (this.activeTab === 'orders') return this.notifications.filter(n => n.type === 'order');
        if (this.activeTab === 'security') return this.notifications.filter(n => n.type === 'system');
        return [];
    },
    markAllRead() {
        this.notifications.forEach(n => n.is_unread = false);
    },
    dismiss(id) {
        this.notifications = this.notifications.filter(n => n.id !== id);
    }
}">
    <!-- Header -->
    <div class="mb-12 flex items-end justify-between animate-on-load">
        <div>
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 bg-brand-primary/5 rounded-full border border-brand-primary/10 mb-6 group cursor-default">
                <div class="w-1.5 h-1.5 rounded-full bg-brand-primary group-hover:scale-125 transition-transform duration-500"></div>
                <span class="text-[10px] font-black text-brand-primary uppercase tracking-[0.2em]">Activity Feed</span>
            </div>
            <h1 class="text-6xl font-bold text-brand-dark tracking-tighter mb-4">Notifications</h1>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em]">Stay updated with your latest transactions and platform news.</p>
        </div>
        <div class="flex items-center gap-4 pb-2" x-show="unreadCount > 0" x-transition>
            <button @click="markAllRead()" class="text-[10px] font-black text-brand-primary uppercase tracking-widest hover:tracking-[0.2em] transition-all">Mark all as read</button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex items-center gap-4 mb-10 overflow-x-auto pb-4 scrollbar-hide animate-on-load">
        <button @click="activeTab = 'all'" 
                :class="activeTab === 'all' ? 'bg-brand-dark text-white shadow-xl shadow-brand-dark/20' : 'bg-white text-slate-400 hover:bg-slate-50'"
                class="px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all whitespace-nowrap">
            All Feed
        </button>
        <button @click="activeTab = 'unread'" 
                :class="activeTab === 'unread' ? 'bg-brand-dark text-white shadow-xl shadow-brand-dark/20' : 'bg-white text-slate-400 hover:bg-slate-50'"
                class="px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-3">
            Unread
            <span x-show="unreadCount > 0" x-text="unreadCount" class="w-5 h-5 flex items-center justify-center bg-brand-primary text-white text-[9px] rounded-lg"></span>
        </button>
        <button @click="activeTab = 'orders'" 
                :class="activeTab === 'orders' ? 'bg-brand-dark text-white shadow-xl shadow-brand-dark/20' : 'bg-white text-slate-400 hover:bg-slate-50'"
                class="px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
            Orders
        </button>
        <button @click="activeTab = 'security'" 
                :class="activeTab === 'security' ? 'bg-brand-dark text-white shadow-xl shadow-brand-dark/20' : 'bg-white text-slate-400 hover:bg-slate-50'"
                class="px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
            Security
        </button>
    </div>

    <!-- Notification List -->
    <div class="space-y-6 min-h-[400px]">
        <template x-for="notif in filteredNotifications" :key="notif.id">
            <div class="notification-item group p-8 rounded-[2.5rem] border border-slate-100/60"
                 :class="notif.is_unread ? 'bg-[#F0FAFC]' : 'bg-slate-50/30'">
                <div class="flex items-start gap-8">
                    <div class="detail-icon-box w-14 h-14 rounded-2xl bg-white flex items-center justify-center shadow-sm flex-shrink-0 group-hover:scale-110 transition-transform"
                         :class="'text-' + notif.color"
                         x-html="notif.icon">
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <h3 class="text-xl font-bold text-brand-dark tracking-tight" x-text="notif.title"></h3>
                                <template x-if="notif.is_unread">
                                    <div class="w-1.5 h-1.5 rounded-full bg-brand-cyan unread-dot"></div>
                                </template>
                            </div>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest" x-text="notif.time"></span>
                        </div>
                        <p class="text-[13px] text-slate-500 leading-relaxed max-w-2xl font-medium" x-text="notif.message"></p>
                        <div class="pt-4 flex items-center gap-6">
                            <template x-if="notif.type === 'order'">
                                <a href="{{ route('customer.order-details.preview') }}" class="text-[10px] font-black text-brand-primary uppercase tracking-[0.2em] flex items-center gap-2 group/btn">
                                    View Order <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="group-hover/btn:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                                </a>
                            </template>
                            <button @click="dismiss(notif.id)" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-brand-dark transition-colors">Dismiss</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Empty State Categories -->
        <div x-show="filteredNotifications.length === 0" class="py-20 text-center animate-on-load">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-slate-300"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <h3 class="text-lg font-bold text-brand-dark mb-2">Semua bersih!</h3>
            <p class="text-slate-400 text-sm italic font-georgia-italic">Tidak ada notifikasi di kategori ini.</p>
        </div>
    </div>
</div>
@endsection
