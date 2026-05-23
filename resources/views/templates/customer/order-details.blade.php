@extends('layouts.customer')

@section('title', 'Order Information')

@section('content')
@php
    $type = request()->get('type', 'cleaning');
    
    $data = [
        'cleaning' => [
            'id' => '#BWP-2026-0001',
            'service' => 'Deep Cleaning Service',
            'provider' => 'BWP Cleaning Service',
            'location' => "Jl. Raya Canggu No. 88, Banjar Anyar\nKuta Utara, Badung, Bali\n80361",
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
            'steps' => [
                ['label' => 'Order Created', 'date' => '14 Jan, 15:30', 'status' => 'completed'],
                ['label' => 'Admin Review', 'date' => 'In Progress', 'status' => 'active'],
                ['label' => 'Price Quote', 'date' => '', 'status' => 'pending'],
                ['label' => 'Payment', 'date' => '', 'status' => 'pending'],
                ['label' => 'Cleaning Process', 'date' => '', 'status' => 'pending'],
                ['label' => 'Completed', 'date' => '', 'status' => 'pending'],
            ],
            'note' => "Ada 2 kamar mandi yang perlu dibersihkan, 1 ruang tamu, dan dapur."
        ],
        'website' => [
            'id' => '#WEB-2026-0055',
            'service' => 'E-Commerce Development',
            'provider' => 'Tech Solutions JOS',
            'location' => 'Remote / Cloud Infrastructure',
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
            'steps' => [
                ['label' => 'Project Kickoff', 'date' => '24 Feb, 09:00', 'status' => 'completed'],
                ['label' => 'Admin Review', 'date' => 'Reviewing Brief', 'status' => 'active'],
                ['label' => 'Design & UI/UX', 'date' => '', 'status' => 'pending'],
                ['label' => 'Development', 'date' => '', 'status' => 'pending'],
                ['label' => 'QA & Testing', 'date' => '', 'status' => 'pending'],
                ['label' => 'Deployment', 'date' => '', 'status' => 'pending'],
            ],
            'note' => "Integrasi dengan payment gateway Midtrans dan kurir JNE/J&T."
        ],
        'skripsi' => [
            'id' => '#SKR-2026-0088',
            'service' => 'Bimbingan Olah Data',
            'provider' => 'Akademika JOS Center',
            'location' => 'Online / Zoom Meeting',
            'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
            'steps' => [
                ['label' => 'Order Created', 'date' => '22 Feb, 10:00', 'status' => 'completed'],
                ['label' => 'Staff Assign', 'date' => 'Finding Mentor', 'status' => 'active'],
                ['label' => 'Data Review', 'date' => '', 'status' => 'pending'],
                ['label' => 'Analysis Process', 'date' => '', 'status' => 'pending'],
                ['label' => 'Consultation', 'date' => '', 'status' => 'pending'],
                ['label' => 'Completed', 'date' => '', 'status' => 'pending'],
            ],
            'note' => "Analisis regresi linear berganda menggunakan SPSS."
        ]
    ];

    $current = $data[$type] ?? $data['cleaning'];
    $steps = $current['steps'];
@endphp

<div class="max-w-6xl mx-auto px-6 lg:px-8">
    <div class="mb-10">
        <a href="{{ route('customer.orders.preview') }}" class="group inline-flex items-center gap-3 text-xs font-black text-slate-400 hover:text-brand-primary transition-all">
            <div class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center group-hover:bg-brand-primary/5 group-hover:border-brand-primary/20 transition-all">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="transition-transform group-hover:-translate-x-0.5"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
            </div>
            <span class="uppercase tracking-[0.2em]">Back to Orders</span>
        </a>
    </div>

    @include('templates.customer.order-details.header', ['current' => $current, 'steps' => $steps])
    @include('templates.customer.order-details.stepper', ['steps' => $steps])
    @include('templates.customer.order-details.banner', ['current' => $current])

    <div class="grid lg:grid-cols-3 gap-8 lg:gap-12">
        <div class="lg:col-span-2 space-y-12">
            @include('templates.customer.order-details.service-info', ['current' => $current])
            @include('templates.customer.order-details.timeline', ['current' => $current])
            @include('templates.customer.order-details.actions')
        </div>
        <div class="lg:col-span-1">
            @include('templates.customer.order-details.sidebar', ['current' => $current])
        </div>
    </div>
</div>
@endsection
