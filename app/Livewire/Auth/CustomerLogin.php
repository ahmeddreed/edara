<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Customer;
use Livewire\Attributes\Layout;

class CustomerLogin extends Component
{
    #[Layout("layouts.auth")]


    public $name;
    public $phone;

    public function render()
    {
        return view('livewire.auth.customer-login');
    }

    public function customerLogin(){

        $this->validate([
            'name' => ['required', 'string',"max:100","min:5"],
            'phone'=>['required'],
        ]);

        $customer = Customer::where("phone",$this->phone)->first();
        if($customer and $customer->name  == $this->name){

            session()->put("customer",$customer);
            session()->put("customer-invoice",1000);
            session()->flash("msg_s","تم تسجيل البيانات بنجاح");
            return redirect()->route("profile");
        }else{

            session()->flash("msg_e"," عذرا يوجد خطا");
        }

        $this->reset();
    }
}
