<?php

namespace App\Livewire\AdminUmkm\Product;

use App\Models\Product;
use App\Models\Umkm;
use App\Services\Product\ProductService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Layout('layouts.admin-umkm')]
class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($productId)
    {
        $product = Product::find($productId);
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');
        
        if ($product && $product->umkm_id === $umkmId) {
            $product->update([
                'is_active' => !$product->is_active
            ]);
        }
    }

    public function edit($productId)
    {
        return redirect()->route('umkm.services.edit', $productId);
    }

    public function delete($productId)
    {
        $product = Product::find($productId);
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        if ($product && $product->umkm_id === $umkmId) {
            $service = app(ProductService::class);
            $service->delete($product);
            $this->dispatch('notify', ['message' => 'Layanan berhasil dihapus', 'type' => 'success']);
        }
    }

    public function render()
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        $query = Product::where('umkm_id', $umkmId)->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('type', 'like', '%' . $this->search . '%');
            });
        }

        $products = $query->paginate(9);

        return view('livewire.admin-umkm.product.index', [
            'products' => $products
        ]);
    }
}
