<?php

namespace App\Livewire;

use App\Models\Material;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout("layouts.main")]
class ItemDetails extends Component
{

    public $material;

    public function mount($id)
    {
        $this->material = Material::findOrFail($id);
    }

    public function render()
    {

        return view('livewire.item-details');
    }
}
