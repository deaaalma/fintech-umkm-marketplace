<?php

namespace App\Livewire\AdminUmkm\Product;

use App\Models\Product;
use App\Models\Umkm;
use App\Services\Product\ProductService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin-umkm')]
class Create extends Component
{
    use WithFileUploads;

    // Main Info
    public $name = '';
    public $type = '';
    public $short_description = '';
    
    // Rich Text
    public $description = '';

    // Price & Duration
    public $price = '';
    public $unit_type = '/m²';
    public $duration_value = '';
    public $duration_unit = 'hari';
    
    // Images
    public $images = [];
    public $imagePreviews = []; // Max 3

    // Extra fields from mockup
    public $features = [''];
    public $terms = '';
    
    // Visibility
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ];

    public function updatedImages()
    {
        // Limit to 3 images
        foreach ($this->images as $img) {
            if (count($this->imagePreviews) < 3) {
                $this->imagePreviews[] = $img;
            }
        }
        $this->images = []; // Reset input
    }

    public function removeImage($index)
    {
        unset($this->imagePreviews[$index]);
        $this->imagePreviews = array_values($this->imagePreviews);
    }

    public function addFeature()
    {
        $this->features[] = '';
    }

    public function removeFeature($index)
    {
        if (count($this->features) > 1) {
            unset($this->features[$index]);
            $this->features = array_values($this->features);
        }
    }

    public function saveAsDraft()
    {
        $this->is_active = false;
        $this->save();
    }

    public function save()
    {
        $this->validate();

        $umkmId = Umkm::where('owner_id', auth()->id())->value('id');

        // Convert duration to minutes
        $durationMinutes = null;
        if ($this->duration_value) {
            if ($this->duration_unit === 'hari') {
                $durationMinutes = $this->duration_value * 24 * 60;
            } elseif ($this->duration_unit === 'jam') {
                $durationMinutes = $this->duration_value * 60;
            } else {
                $durationMinutes = $this->duration_value;
            }
        }

        // Process images (Since DB only supports 1, we save the first one)
        $thumbnailPath = null;
        if (count($this->imagePreviews) > 0) {
            $thumbnailPath = $this->imagePreviews[0]->store('products', 'public');
        }

        // Pack extra data into description HTML since user wants to use existing table
        $finalDescription = $this->description;
        
        // Optionally append features and terms if they exist (to preserve data visually without DB schema changes)
        if (!empty(array_filter($this->features))) {
            $finalDescription .= "<h4>Apa Yang Termasuk:</h4><ul>";
            foreach (array_filter($this->features) as $f) {
                $finalDescription .= "<li>" . htmlspecialchars($f) . "</li>";
            }
            $finalDescription .= "</ul>";
        }
        if ($this->terms) {
            $finalDescription .= "<h4>Syarat & Ketentuan:</h4><p>" . nl2br(htmlspecialchars($this->terms)) . "</p>";
        }
        if ($this->short_description) {
            $finalDescription = "<p><strong>" . htmlspecialchars($this->short_description) . "</strong></p>" . $finalDescription;
        }

        // Use ProductService for creation
        $service = app(ProductService::class);
        $service->create([
            'umkm_id' => $umkmId,
            'name' => $this->name,
            'type' => $this->type,
            'description' => $finalDescription,
            'estimated_price' => $this->price,
            'duration_minutes' => $durationMinutes,
            'is_active' => $this->is_active,
        ], count($this->imagePreviews) > 0 ? $this->imagePreviews[0] : null);

        return redirect()->route('umkm.services');
    }

    public function render()
    {
        return view('livewire.admin-umkm.product.create');
    }
}
