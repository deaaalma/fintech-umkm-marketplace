@extends('layouts.customer-layout')

@section('title', 'Explore Partners')

@section('extra-styles')
    .partner-card {
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .partner-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px -15px rgba(0, 11, 68, 0.1);
    }
    .partner-img-overlay {
        background: linear-gradient(to top, rgba(0, 11, 68, 0.6) 0%, transparent 100%);
    }
@endsection

@section('content')
@php
    $categories = [
        ['id' => 'semua', 'label' => 'Semua'],
        ['id' => 'digital', 'label' => 'Digital'],
        ['id' => 'cleaning', 'label' => 'Cleaning'],
        ['id' => 'catering', 'label' => 'Catering'],
        ['id' => 'laundry', 'label' => 'Laundry'],
    ];

    $partners = [
        [
            'name' => 'Tech Solutions JOS',
            'category' => 'digital',
            'desc' => 'Spesialis website e-commerce & mobile apps dengan standar premium.',
            'rating' => 4.9,
            'reviews' => 128,
            'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&q=80',
            'verified' => true
        ],
        [
            'name' => 'BWP Cleaning Service',
            'category' => 'cleaning',
            'desc' => 'Layanan pembersihan mendalam untuk properti mewah di area Bali.',
            'rating' => 5.0,
            'reviews' => 450,
            'img' => 'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=500&q=80',
            'verified' => true
        ],
        [
            'name' => 'Akademika JOS Center',
            'category' => 'digital',
            'desc' => 'Bimbingan analisis data skripsi dan olah data profesional.',
            'rating' => 4.8,
            'reviews' => 89,
            'img' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=500&q=80',
            'verified' => true
        ],
        [
            'name' => 'Flavor JOS Catering',
            'category' => 'catering',
            'desc' => 'Katering harian dan event dengan menu sehat khas cita rasa lokal.',
            'rating' => 4.7,
            'reviews' => 210,
            'img' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=500&q=80',
            'verified' => false
        ],
    ];
@endphp

<div class="max-w-6xl mx-auto px-6" x-data="{ 
    activeCategory: 'semua',
    search: '',
    allPartners: @js($partners)
}">
    @include('templates.customer.partners.header')
    @include('templates.customer.partners.filters', ['categories' => $categories])
    @include('templates.customer.partners.grid')
</div>
@endsection

@push('scripts')
<script>
    gsap.from('.animate-on-load', {
        y: 20,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out'
    });
</script>
@endpush
