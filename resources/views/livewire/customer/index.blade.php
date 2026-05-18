<div class="max-w-6xl mx-auto px-6">
    {{-- Memanggil Komponen --}}
    <x-customer.header :name="auth()->user()->name" />
    
    <x-customer.stats 
        :active-count="$activeOrdersCount" 
        :success-count="$successOrdersCount" 
    />

    <div class="grid lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2">
            <x-customer.recent-activities :order="$recentOrder" />
        </div>

        <div class="space-y-10">
            <x-customer.recommendations :partners="$partners" />
            <x-customer.notifications 
                :count="$notifCount" 
                :notifications="$notifications" 
            />
        </div>
    </div>
</div>