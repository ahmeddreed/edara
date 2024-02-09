<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Customer;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

class CustomerTable extends Component
{


    #[Layout("layouts.dashboard")]



    public $customer_id;
    public $customer_id_enc = "";
    public $customer;


    //Fields
    public $name;
    public $phone;
    public $address;
    public $governorate;


    public $search = "";
    public $show = "table";


    public function  __construct() {

        //Middleware in another way
        if(auth()->user()->role_id !=1){

            $this->redirect("/Dashboard");
        }
    }



    public function render()
    {

        $customers = $this->showData();
        return view('livewire.dashboard.customer-table',compact("customers"));
    }


    public function showData(){///////// show defualt data ////////

        $data = Customer::latest()->paginate(10);
        if($this->search){//searching

           $data = Customer::where('name','like','%'.$this->search.'%')->orWhere('address','like','%'.$this->search.'%')->paginate(10);
        }

        return $data;
    }



    public function showChange($name, $id = null,$enc =null){/////////show page section////////

        if($name === "add" or $name === "delete" and $id != null and $enc != null){

            //set data
           $this->customer_id = $id;
           $this->customer = Customer::find($id);
           $this->customer_id_enc = $enc;
           $this->show = $name;

        }else{

           $this->show = "table";
        }

   }




   public function create(){//////create customer//////

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


    session()->flash("msg_s","تم انشاء الحساب بنجاح");

    //reset the data
    $this->reset();
}



public function delete(){
    //check the encrypt value
    if(Hash::check($this->customer_id,$this->customer_id_enc)){
        //get the data
        $customer = $this->customer;

        //delete customer
        $customer->delete();

        //success message
        session()->flash("msg_s","تم الحذف بنجاح");

        //reset the data
        $this->reset();
    }else{
         //error message
         session()->flash("msg_s"," التشفير غير مطابق");
    }
}


   public function cancel(){////////reset the data///////

    $this->reset();
}

}
