<x-slot:title>Order Lists</x-slot>

<div class="space-y-6">
    {{-- Breadcrumbs --}}
    <nav class="flex text-sm text-gray-500 font-medium" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="#" class="hover:text-gray-700">Home</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 md:ml-2">Orders</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Title and Action --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Order Management ({{ $orders_pagination->total() }})</h1>
        <button class="bg-[#2D2D2D] hover:bg-black text-white px-6 py-2.5 rounded-xl font-bold flex items-center gap-2 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Manual Order
        </button>
    </div>

    {{-- Status Tabs --}}
    <div class="border-b border-gray-200">
        <div class="flex flex-wrap -mb-px">
            @php
                $tabs = [
                    'All' => 'All',
                    'Pending Review' => 'Pending Review',
                    'Negotiating' => 'Negotiating',
                    'Awaiting Payment' => 'Awaiting Payment',
                    'Paid' => 'Paid',
                    'In Process' => 'In Process',
                    'Completed' => 'Completed',
                    'Cancelled' => 'Cancelled'
                ];
            @endphp
            @foreach($tabs as $key => $label)
                <button wire:click="$set('category', '{{ $key }}')" 
                    class="mr-8 py-4 px-1 border-b-2 font-bold text-sm transition-all whitespace-nowrap
                    {{ $category == $key 
                        ? 'border-[#2D2D2D] text-[#2D2D2D]' 
                        : 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-300' }}">
                    {{ $label }} {{-- Mock count here if needed --}}
                </button>
            @endforeach
        </div>
    </div>


    {{-- Search and Filters --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
        <div class="flex items-center gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" wire:model.live="search" 
                    placeholder="Search by Order ID, customer name, phone, service..." 
                    class="block w-full pl-11 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-300 sm:text-sm transition-all">
            </div>
            <button wire:click="$toggle('showFilters')" 
                class="flex items-center gap-2 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition-all">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filters (2)
            </button>
        </div>

        @if($showFilters)
        <div class="grid grid-cols-1 md:grid-cols-5 gap-8 pt-6 border-t border-gray-100">
            {{-- Date Range --}}
            <div class="space-y-4">
                <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider">Date Range</label>
                <div class="flex gap-2">
                    <button wire:click="setDateRange('today')" class="px-4 py-2 text-xs font-bold border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-all">Today</button>
                    <button wire:click="setDateRange('week')" class="px-4 py-2 text-xs font-bold border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-all">Week</button>
                    <button wire:click="setDateRange('month')" class="px-4 py-2 text-xs font-bold border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-all">Month</button>
                </div>
                <div class="space-y-2">
                    <input type="date" wire:model.live="date_start" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm">
                    <input type="date" wire:model.live="date_end" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm">
                </div>
                <button wire:click="$set('date_start', ''); $set('date_end', '')" class="text-xs text-gray-400 font-bold hover:text-gray-600 underline">Clear All</button>
            </div>

            {{-- Service Type --}}
            <div class="space-y-4">
                <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider">Service Type</label>
                <select wire:model.live="service_type" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-500">
                    <option value="">Select service</option>
                    @foreach($serviceTypes as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-gray-400 font-medium">2 services selected</p>
            </div>

            {{-- Staff Assignment --}}
            <div class="space-y-4">
                <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider">Staff Assignment</label>
                <select wire:model.live="staff_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-500">
                    <option value="">Select staff</option>
                    @foreach($staffs as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Amount Range --}}
            <div class="space-y-4">
                <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider">Amount Range</label>
                <div class="space-y-2">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-xs">Min: Rp</span>
                        <input type="number" wire:model.live="amount_min" class="w-full pl-16 pr-4 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-xs">Max: Rp</span>
                        <input type="number" wire:model.live="amount_max" class="w-full pl-16 pr-4 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                </div>
            </div>

            {{-- Customer Type --}}
            <div class="space-y-4">
                <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider">Customer Type</label>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model.live="customer_type" value="All" name="customer_type" class="w-4 h-4 text-black border-gray-300 focus:ring-black">
                        <span class="text-sm font-medium text-gray-700">All</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model.live="customer_type" value="New" name="customer_type" class="w-4 h-4 text-black border-gray-300 focus:ring-black">
                        <span class="text-sm font-medium text-gray-700">New</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model.live="customer_type" value="Returning" name="customer_type" class="w-4 h-4 text-black border-gray-300 focus:ring-black">
                        <span class="text-sm font-medium text-gray-700">Returning</span>
                    </label>
                </div>
                <div class="pt-4 flex justify-end">
                    <button wire:click="$toggle('showFilters')" class="bg-[#2D2D2D] text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-black transition-all">Close Filters</button>
                </div>
            </div>
        </div>
        @endif

        {{-- Active Filter Tags --}}
        @if($service_type || $staff_id)
        <div class="flex flex-wrap items-center gap-3 pt-2">
            @if($service_type)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-lg">
                <span class="text-xs font-bold text-gray-600">Service: {{ $service_type }}</span>
                <button wire:click="$set('service_type', '')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            @if($staff_id)
            @php $selectedStaff = $staffs->firstWhere('id', $staff_id); @endphp
            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-lg">
                <span class="text-xs font-bold text-gray-600">Staff: {{ $selectedStaff ? $selectedStaff->name : $staff_id }}</span>
                <button wire:click="$set('staff_id', '')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            @if($date_start || $date_end)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-lg">
                <span class="text-xs font-bold text-gray-600">Date: {{ $date_start }} {{ $date_end ? 'to '.$date_end : '' }}</span>
                <button wire:click="$set('date_start', ''); $set('date_end', '')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            @if($amount_min || $amount_max)
            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-lg">
                <span class="text-xs font-bold text-gray-600">Amount: {{ $amount_min ? 'Rp'.$amount_min : 'Min' }} - {{ $amount_max ? 'Rp'.$amount_max : 'Max' }}</span>
                <button wire:click="$set('amount_min', ''); $set('amount_max', '')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif

            @if($customer_type && $customer_type != 'All')
            <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-lg">
                <span class="text-xs font-bold text-gray-600">Customer: {{ $customer_type }}</span>
                <button wire:click="$set('customer_type', 'All')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif
            
            <button wire:click="resetFilters" class="text-xs text-gray-400 font-bold hover:text-gray-600 underline ml-2">Clear all filters</button>
        </div>
        @endif
    </div>


    {{-- Bulk Action Bar --}}
    @if(count($selected) > 0)
    <div class="flex items-center justify-between bg-[#2D2D2D] text-white p-4 rounded-xl shadow-lg animate-in fade-in slide-in-from-bottom-4 duration-300">
        <div class="flex items-center gap-4 pl-4">
            <span class="text-sm font-bold">{{ count($selected) }} selected</span>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-6 py-2 border border-gray-600 rounded-lg text-sm font-bold hover:bg-gray-800 transition-all">Send Reminder</button>
            <button class="px-6 py-2 border border-gray-600 rounded-lg text-sm font-bold hover:bg-gray-800 transition-all">Export Selected</button>
            <button wire:click="$set('selected', [])" class="p-2 text-gray-400 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
    @endif

    {{-- Table Section --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4">
                            <input type="checkbox" wire:click="selectAll(@json($orders->pluck('id')))" 
                                {{ count($selected) === count($orders) && count($orders) > 0 ? 'checked' : '' }}
                                class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black cursor-pointer">
                        </th>
                        <th class="px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Order ID <svg class="inline w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5 12l5 5 5-5H5z"/></svg></th>
                        <th class="px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Booking Date <svg class="inline w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5 12l5 5 5-5H5z"/></svg></th>
                        <th class="px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Created <svg class="inline w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5 12l5 5 5-5H5z"/></svg></th>
                        <th class="px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Staff</th>
                        <th class="px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-700">
                    @forelse($orders as $o)
                    <tr class="hover:bg-gray-50/50 transition-all {{ in_array($o['id'], $selected) ? 'bg-gray-50' : '' }}">
                        <td class="px-6 py-4">
                            <input type="checkbox" wire:model.live="selected" value="{{ $o['id'] }}" class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black cursor-pointer">
                        </td>

                        <td class="px-4 py-4">
                            <span class="text-sm font-bold text-gray-900 underline decoration-gray-300 underline-offset-4">{{ $o['id'] }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                    {{ substr($o['client'], 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $o['client'] }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-gray-600">{{ $o['service'] }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-gray-600">{{ $o['booking'] }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm text-gray-600">{{ $o['time'] }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                @if($o['color'] == 'amber') bg-amber-50 text-amber-600 
                                @elseif($o['color'] == 'orange') bg-orange-50 text-orange-600
                                @elseif($o['color'] == 'teal') bg-teal-50 text-teal-600 
                                @elseif($o['color'] == 'blue') bg-blue-50 text-blue-600 
                                @elseif($o['color'] == 'green') bg-green-50 text-green-600
                                @elseif($o['color'] == 'red') bg-red-50 text-red-600
                                @else bg-gray-100 text-gray-500 @endif">
                                {{ $o['status'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-sm font-bold text-gray-900">{{ $o['price'] }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-sm text-gray-400">{{ $o['staff'] }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <a href="{{ route('umkm.orders.show', $o['id_raw']) }}" class="bg-[#2D2D2D] text-white px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-black transition-all inline-block">
                                Review & Chat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-gray-400 text-sm font-medium">No orders found matching your criteria.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="pt-4 pb-8">
        {{ $orders_pagination->links('components.custom-pagination') }}
    </div>
</div>