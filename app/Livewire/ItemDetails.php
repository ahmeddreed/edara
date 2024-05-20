<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Material;
use Livewire\Attributes\Layout;


#[Layout("layouts.main")]
class ItemDetails extends Component
{

    public $material;
    public $category;

    public function mount($id)
    {
        $this->material = Material::findOrFail($id);
        $this->category = Category::find($this->material->category_id);
    }

    public function render()
    {

        return view('livewire.item-details');
    }
}
