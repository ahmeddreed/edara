<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("layouts.main")]
class Invoice extends Component
{
    public function render()
    {
        return view('livewire.invoice');
    }
}
