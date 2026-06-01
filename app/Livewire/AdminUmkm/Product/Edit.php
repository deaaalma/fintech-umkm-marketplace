<?php

namespace App\Livewire\AdminUmkm\Product;

use App\Models\Product;
use App\Models\Umkm;
use App\Services\Product\ProductService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin-umkm')]
class Edit extends Component
{
    use WithFileUploads;

    public $productId;
    public $product;

    // Main Info
    public $name = '';
    public $type = '';
    
    // Rich Text
    public $description = '';

    // Price & Duration
    public $price = '';
    public $duration_minutes = '';
    
    // Images
    public $thumbnail;
    public $existingThumbnail;

    // Visibility
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'duration_minutes' => 'nullable|numeric|min:0',
        'description' => 'nullable|string',
        'thumbnail' => 'nullable|image|max:2048',
    ];

    public function mount($id)
    {
        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');
        $this->product = Product::where('umkm_id', $umkmId)->findOrFail($id);
        
        $this->productId = $this->product->id;
        $this->name = $this->product->name;
        $this->type = $this->product->type;
        $this->description = $this->product->description;
        $this->price = $this->product->estimated_price;
        $this->duration_minutes = $this->product->duration_minutes;
        $this->is_active = $this->product->is_active;
        $this->existingThumbnail = $this->product->thumbnail_url;
    }

    public function save()
    {
        $this->validate();

        $service = app(ProductService::class);
        $service->update($this->product, [
            'type' => $this->type,
            'name' => $this->name,
            'description' => $this->description,
            'estimated_price' => $this->price,
            'duration_minutes' => $this->duration_minutes,
            'is_active' => $this->is_active,
        ], $this->thumbnail);

        return redirect()->route('umkm.services');
    }

    public function render()
    {
        return view('livewire.admin-umkm.product.edit');
    }
}
