<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Customer;
use Livewire\Attributes\Layout;

class CustomerRegister extends Component
{

    #[Layout("layouts.auth")]


    public $name;
    public $phone;
    public $address;
    public $governorate;
    public function render()
    {
        return view('livewire.auth.customer-register');
    }

    public function customerRegister(){

            $this->validate([
                'name' => ['required', 'string',"max:100","min:5"],
                'phone'=>['required','unique:customers,phone'],
                'address'=>["required", "string"],
                "governorate"=>["required", "string"]
            ]);


            $customer = Customer::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'address' => $this->address,
                'governorate' => $this->governorate,
            ]);


            session()->put("customer",$customer);
            session()->flash("msg_s","تم انشاء الحساب بنجاح");
            return redirect()->route("profile");

    }

}
