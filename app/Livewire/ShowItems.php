<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Material;
use Livewire\Attributes\Layout;

class ShowItems extends Component
{

    #[Layout("layouts.main")]

    public $category_id;
    public $category;
    public $materials;
    public $search;
    public function mount($id)
    {
        $this->category = Category::find($id);
    }
    public function render()
    {
        return view('livewire.show-items');
    }
}
