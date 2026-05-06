<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new 
#[Layout('layouts.app')] // Pastikan ini pakai layout dashboard utama
class extends Component
{
    // Logic admin nanti disini
}; ?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-800">Halaman Worker</h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 transition duration-150 shadow-md flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

            <div class="text-gray-600">
                <p>Halo Worker! Selamat bekerja.</p>
                </div>

        </div>
    </div>
</div>