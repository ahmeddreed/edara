<?php

namespace App\Livewire\Auth;

use App\Models\Customer;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;

#[Layout("layouts.auth")]
class Auth extends Component
{

    public $action = "customer register";
    public $name;
    public $email;
    public $password;
    public $phone;
    public $address;
    public $governorate;


    public function render()
    {
        return view('livewire.auth.auth');
    }



    public function customerLogin(){
        if($this->action == "customer register" and !session()->has("customer")){

            $this->validate([
                'name' => ['required', 'string',"max:100","min:5"],
                'phone'=>['required'],
            ]);

            $customer = Customer::where("phone",$this->phone)->first();

            dd($customer);
        }

    }


    public function customerRegister(){

    if($this->action == "customer register" and !session()->has("customer")){
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
        $this->action = "customer login";
        session()->flash("msg_s","تم انشاء الحساب بنجاح");

    }

    }




    public function changeTheAction($name){

        $this->action = $name;
        $this->reset("name","email","phone","password","address","governorate");
    }
}
