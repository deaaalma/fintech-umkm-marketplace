@extends('layouts.customer')

@section('title', 'Dashboard')

@section('extra-styles')
    .premium-card-hover {
        transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        border: 1px solid #f1f5f9;
    }
    .premium-card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(0, 11, 68, 0.08);
        border-color: var(--brand-soft);
    }
    .stat-card-blue { background-color: var(--brand-dark); }
    .stat-card-cyan { background-color: var(--brand-primary); }
@endsection

@section('content')
@php
    $user = ['name' => 'Ahmad'];
@endphp

<div class="max-w-6xl mx-auto">
    @include('templates.customer.dashboard.header', ['user' => $user])
    @include('templates.customer.dashboard.stats')

    {{-- <div class="grid lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2 space-y-8 animate-on-scroll">
            @include('templates.customer.dashboard.recent-activities')
        </div>
        <div class="space-y-10 animate-on-scroll">
            @include('templates.customer.dashboard.recommendations')
            @include('templates.customer.dashboard.notifications')
        </div>
    </div> --}}
</div>

<div id="floating-notification" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[100] w-[90%] max-w-md pointer-events-none opacity-0 translate-y-20">
    <div class="bg-brand-dark/95 backdrop-blur-xl border border-white/10 p-5 rounded-[2rem] shadow-2xl flex items-center gap-5 pointer-events-auto">
        <div class="w-12 h-12 rounded-2xl bg-brand-primary flex items-center justify-center text-white flex-shrink-0">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        </div>
        <div class="flex-1">
            <div class="text-[10px] font-black text-brand-cyan uppercase tracking-[0.2em] mb-1">New Update</div>
            <p class="text-xs font-bold text-white leading-tight">Pre-invoice dikirim untuk pesanan #BWP-2026-0001</p>
        </div>
        <button onclick="gsap.to('#floating-notification', {y: 100, opacity: 0, duration: 0.5})" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-white/40 hover:text-white transition-colors">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>
</div>
@endsection

@push('scripts')
    const container = document.getElementById('typewriter-container');
    const cursor = document.getElementById('typewriter-cursor');
    
    if(container && cursor) {
        gsap.set(container, { width: 0 });
        gsap.set(cursor, { opacity: 0 });

        gsap.to(cursor, { 
            opacity: 1, 
            repeat: -1, 
            duration: 0.5, 
            yoyo: true, 
            ease: 'power2.inOut' 
        });

        gsap.to(container, {
            width: 'auto',
            duration: 1.5,
            ease: 'none',
            delay: 0.8,
            onStart: () => {
                gsap.set(cursor, { opacity: 1 });
            }
        });
    }

    gsap.utils.toArray('.animate-on-scroll').forEach(section => {
        gsap.fromTo(section, 
            { opacity: 0, y: 40 },
            {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: section,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            }
        );
    });

    gsap.to('#floating-notification', {
        y: 0,
        opacity: 1,
        duration: 1.2,
        delay: 2,
        ease: 'elastic.out(1, 0.8)'
    });

    gsap.from('.notification-item', {
        y: 20,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        delay: 1.5,
        ease: 'power3.out'
    });
@endpush
