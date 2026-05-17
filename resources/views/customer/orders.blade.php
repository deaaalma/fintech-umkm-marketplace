@extends('layouts.customer')

@section('title', 'My Orders')

@section('extra-head')
    <!-- Flatpickr (Premium Calendar) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection

@section('extra-styles')
    .order-item {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .order-item:hover {
        transform: translateY(-8px) scale(1.01);
        border-color: rgba(0, 119, 182, 0.3);
        box-shadow: 0 20px 40px -10px rgba(0, 11, 68, 0.05);
    }

    @keyframes subtleBreath {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.005); }
    }

    .breath-active {
        animation: subtleBreath 3s ease-in-out infinite;
    }

    .flatpickr-calendar {
        border-radius: 1.5rem !important;
        box-shadow: 0 25px 50px -12px rgba(0, 11, 68, 0.1) !important;
        border: 1px solid #f1f5f9 !important;
        padding: 10px !important;
        font-family: var(--font-figtree) !important;
    }
    .flatpickr-day.selected {
        background: var(--brand-dark) !important;
        border-color: var(--brand-dark) !important;
    }
    .flatpickr-day:hover { background: #f8fafc !important; }
@endsection

@section('content')
@php
    $orders = [
        [
            'id' => 'BWP-2026-0001',
            'tab' => 'menunggu',
            'service' => 'Deep Cleaning Service',
            'status' => 'Review Admin',
            'type' => 'action_required',
            'alert' => 'Admin telah mengirim pre-invoice. Silakan review sebelum melakukan pembayaran.',
            'date' => '14 Jan 2026',
            'target_date' => '16 Jan 2026',
            'time' => '10:00 WIB',
            'location' => 'Denpasar, Bali',
            'provider' => 'BWP Cleaning Service',
            'timestamp' => '2026-01-14T15:30:00'
        ],
        [
            'id' => 'WEB-2026-0055',
            'tab' => 'proses',
            'service' => 'E-Commerce Development',
            'status' => 'Development',
            'type' => 'in_progress',
            'progress' => 45,
            'date' => '24 Feb 2026',
            'target_date' => '15 Mar 2026',
            'time' => 'Remote',
            'location' => 'Cloud Infra',
            'provider' => 'Tech Solutions JOS',
            'timestamp' => '2026-02-24T09:00:00'
        ],
        [
            'id' => 'SKR-2026-0088',
            'tab' => 'menunggu',
            'service' => 'Bimbingan Skripsi',
            'status' => 'Assigning Mentor',
            'type' => 'action_required',
            'alert' => 'Sedang mencocokkan mentor yang sesuai dengan topik penelitian Anda.',
            'date' => '22 Feb 2026',
            'target_date' => '25 Feb 2026',
            'time' => '19:00 WIB',
            'location' => 'Zoom Meeting',
            'provider' => 'Akademika JOS',
            'timestamp' => '2026-02-22T10:00:00'
        ],
        [
            'id' => 'BWP-2026-0012',
            'tab' => 'selesai',
            'service' => 'Office Maintenance',
            'status' => 'Completed',
            'type' => 'completed',
            'date' => '05 Jan 2026',
            'target_date' => '06 Jan 2026',
            'time' => '09:00 WIB',
            'location' => 'Renon, Denpasar',
            'provider' => 'BWP Cleaning Service',
            'timestamp' => '2026-01-05T09:00:00'
        ],
        [
            'id' => 'WEB-2026-0060',
            'tab' => 'proses',
            'service' => 'Company Profile Web',
            'status' => 'UI Design Phase',
            'type' => 'in_progress',
            'progress' => 30,
            'date' => '28 Feb 2026',
            'target_date' => '10 Mar 2026',
            'time' => 'Remote',
            'location' => 'Office Hub',
            'provider' => 'Tech Solutions JOS',
            'timestamp' => '2026-02-28T14:00:00'
        ],
        [
            'id' => 'SKR-2026-0095',
            'tab' => 'selesai',
            'service' => 'Analisis Data SPSS',
            'status' => 'Result Sent',
            'type' => 'completed',
            'date' => '20 Feb 2026',
            'target_date' => '22 Feb 2026',
            'time' => 'Online',
            'location' => 'WhatsApp/Email',
            'provider' => 'Akademika JOS',
            'timestamp' => '2026-02-20T16:00:00'
        ],
        [
            'id' => 'BWP-2026-0015',
            'tab' => 'menunggu',
            'service' => 'Carpet Cleaning',
            'status' => 'Pending Payment',
            'type' => 'action_required',
            'alert' => 'Review invoice terbaru untuk pembersihan area lobi.',
            'date' => '01 Mar 2026',
            'target_date' => '03 Mar 2026',
            'time' => '13:00 WIB',
            'location' => 'Seminyak, Badung',
            'provider' => 'BWP Cleaning Service',
            'timestamp' => '2026-03-01T11:00:00'
        ],
        [
            'id' => 'WEB-2026-0072',
            'tab' => 'proses',
            'service' => 'Mobile App Design',
            'status' => 'Prototyping',
            'type' => 'in_progress',
            'progress' => 75,
            'date' => '15 Feb 2026',
            'target_date' => '05 Mar 2026',
            'time' => 'Remote',
            'location' => 'Design Studio',
            'provider' => 'Tech Solutions JOS',
            'timestamp' => '2026-02-15T10:30:00'
        ],
        [
            'id' => 'SKR-2026-0102',
            'tab' => 'proses',
            'service' => 'Review Jurnal Intl',
            'status' => 'On Review',
            'type' => 'in_progress',
            'progress' => 50,
            'date' => '02 Mar 2026',
            'target_date' => '07 Mar 2026',
            'time' => 'Online',
            'location' => 'Cloud Workspace',
            'provider' => 'Akademika JOS',
            'timestamp' => '2026-03-02T08:00:00'
        ],
        [
            'id' => 'BWP-2026-0020',
            'tab' => 'selesai',
            'service' => 'Garden Watering',
            'status' => 'Task Done',
            'type' => 'completed',
            'date' => '10 Jan 2026',
            'target_date' => '10 Jan 2026',
            'time' => '16:00 WIB',
            'location' => 'Ubud, Gianyar',
            'provider' => 'BWP Cleaning Service',
            'timestamp' => '2026-01-10T16:00:00'
        ],
        [
            'id' => 'WEB-2026-0080',
            'tab' => 'menunggu',
            'service' => 'SEO Optimization',
            'status' => 'Need Access',
            'type' => 'action_required',
            'alert' => 'Tolong berikan akses Google Search Console untuk memulai audit.',
            'date' => '03 Mar 2026',
            'target_date' => '04 Mar 2026',
            'time' => 'Remote',
            'location' => 'Live Support',
            'provider' => 'Tech Solutions JOS',
            'timestamp' => '2026-03-03T09:20:00'
        ],
        [
            'id' => 'SKR-2026-0110',
            'tab' => 'selesai',
            'service' => 'Cek Plagiasi Turnitin',
            'status' => 'Report Ready',
            'type' => 'completed',
            'date' => '01 Mar 2026',
            'target_date' => '01 Mar 2026',
            'time' => 'Online',
            'location' => 'Portal',
            'provider' => 'Akademika JOS',
            'timestamp' => '2026-03-01T20:00:00'
        ],
        [
            'id' => 'BWP-2026-0025',
            'tab' => 'proses',
            'service' => 'Disinfectant Spray',
            'status' => 'Technician Heading',
            'type' => 'in_progress',
            'progress' => 15,
            'date' => '04 Mar 2026',
            'target_date' => '04 Mar 2026',
            'time' => '11:00 WIB',
            'location' => 'Jimbaran, Bali',
            'provider' => 'BWP Cleaning Service',
            'timestamp' => '2026-03-04T10:45:00'
        ],
        [
            'id' => 'WEB-2026-0092',
            'tab' => 'selesai',
            'service' => 'Landing Page UI',
            'status' => 'Accepted',
            'type' => 'completed',
            'date' => '20 Jan 2026',
            'target_date' => '25 Jan 2026',
            'time' => 'Remote',
            'location' => 'Figma Hub',
            'provider' => 'Tech Solutions JOS',
            'timestamp' => '2026-01-20T13:15:00'
        ],
        [
            'id' => 'SKR-2026-0125',
            'tab' => 'menunggu',
            'service' => 'Privat Olah Data R',
            'status' => 'Wait Schedule',
            'type' => 'action_required',
            'alert' => 'Mentor menanyakan ketersediaan waktu Anda di hari Sabtu.',
            'date' => '04 Mar 2026',
            'target_date' => '06 Mar 2026',
            'time' => 'TBA',
            'location' => 'Zoom Meeting',
            'provider' => 'Akademika JOS',
            'timestamp' => '2026-03-04T15:00:00'
        ]
    ];

    $tabs = [
        ['id' => 'semua', 'label' => 'Semua Pesanan', 'count' => count($orders)],
        ['id' => 'menunggu', 'label' => 'Menunggu', 'count' => collect($orders)->where('tab', 'menunggu')->count()],
        ['id' => 'proses', 'label' => 'Dalam Proses', 'count' => collect($orders)->where('tab', 'proses')->count()],
        ['id' => 'selesai', 'label' => 'Selesai', 'count' => collect($orders)->where('tab', 'selesai')->count()],
    ];
@endphp

<div class="max-w-6xl mx-auto px-6 lg:px-8" x-data="{ 
    activeTab: 'semua', 
    search: '', 
    startDate: null,
    endDate: null,
    statusFilter: '',
    showFilterMenu: false,
    currentPage: 1, 
    itemsPerPage: 6,
    allOrders: @js($orders),
    init() {
        flatpickr($refs.dateInput, {
            mode: 'range',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'j M Y',
            onChange: (selectedDates) => {
                if (selectedDates.length === 2) {
                    this.startDate = selectedDates[0];
                    this.endDate = selectedDates[1];
                    this.currentPage = 1;
                    this.$nextTick(() => animateTabs());
                } else if (selectedDates.length === 0) {
                    this.startDate = null;
                    this.endDate = null;
                    this.currentPage = 1;
                    this.$nextTick(() => animateTabs());
                }
            }
        });
    },
    get filteredOrders() {
        if (!Array.isArray(this.allOrders)) return [];
        
        return this.allOrders.filter(o => {
            // Filter Tab
            const matchesTab = this.activeTab === 'semua' || o.tab === this.activeTab;
            
            // Filter Search (Lebih aman dengan check null)
            const searchTerms = this.search.toLowerCase().trim();
            const serviceName = (o.service || '').toLowerCase();
            const orderId = (o.id || '').toLowerCase();
            const matchesSearch = searchTerms === '' || 
                                 serviceName.includes(searchTerms) || 
                                 orderId.includes(searchTerms);
            
            // Filter Status
            const statusTerms = this.statusFilter.toLowerCase().trim();
            const orderStatus = (o.status || '').toLowerCase();
            const matchesStatus = statusTerms === '' || orderStatus.includes(statusTerms);
            
            // Filter Tanggal
            let matchesDate = true;
            if (this.startDate && this.endDate) {
                try {
                    const orderTime = new Date(o.timestamp).getTime();
                    matchesDate = orderTime >= this.startDate.getTime() && orderTime <= this.endDate.getTime();
                } catch (e) {
                    matchesDate = true;
                }
            }
            
            return matchesTab && matchesSearch && matchesStatus && matchesDate;
        });
    },
    get paginatedOrders() {
        const filtered = this.filteredOrders;
        const start = (this.currentPage - 1) * this.itemsPerPage;
        return filtered.slice(start, start + this.itemsPerPage);
    },
    get totalPages() {
        return Math.ceil(this.filteredOrders.length / this.itemsPerPage);
    },
    get activeFilters() {
        let filters = [];
        if (this.startDate && this.endDate) {
            const fmt = (d) => d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            filters.push({ id: 'date', label: 'Rentang: ' + fmt(this.startDate) + ' - ' + fmt(this.endDate) });
        }
        if (this.statusFilter) filters.push({ id: 'status', label: 'Status: ' + this.statusFilter });
        return filters;
    },
    clearFilter(id) {
        if (id === 'date') {
            this.startDate = null;
            this.endDate = null;
            this.$refs.dateInput._flatpickr.clear();
        }
        if (id === 'status') this.statusFilter = '';
        this.currentPage = 1;
        this.$nextTick(() => animateTabs());
    },
    changeTab(id) {
        this.activeTab = id;
        this.currentPage = 1;
        this.$nextTick(() => animateTabs());
    }
}">
    @include('customer.orders.header')
    @include('customer.orders.filters')
    @include('customer.orders.tabs', ['tabs' => $tabs])
    @include('customer.orders.grid')
    @include('customer.orders.pagination')
</div>
@endsection

@push('scripts')
    function animateTabs() {
        gsap.killTweensOf('.order-item');
        gsap.fromTo('.order-item', 
            { opacity: 0, y: 40, scale: 0.98, filter: 'blur(10px)' },
            {
                opacity: 1, y: 0, scale: 1, filter: 'blur(0px)',
                duration: 0.7,
                stagger: { amount: 0.3, from: 'start' },
                ease: 'power4.out',
                clearProps: 'all' 
            }
        );
    }
@endpush
