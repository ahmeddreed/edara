<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;


#[Layout("layouts.auth")]
class CustomerRegister extends Component
{
    public function render()
    {
        return view('livewire.auth.customer-register');
    }
}
