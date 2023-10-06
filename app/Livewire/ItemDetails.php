<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout("layouts.main")]
class ItemDetails extends Component
{
    public function render()
    {
        return view('livewire.item-details');
    }
}
