<?php

namespace App\Livewire\Dashboard;

use App\Models\IMF;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class IMFOperation extends Component
{

    use WithPagination;
    #[Layout("layouts.dashboard")]

    public $imf_id;
    public $imf_data;
    public $user_name;
    public $side_bar = "hide";
    public $side_bar_customer_data = "customer list";
    public $operation_type;
    public $customer_id;
    public $customer;
    public $customer_name;
    public $customers;
    public $old_number = 0;
    public $new_number = 0;
    public $number = 0;
    public $show_all;
    public $note;
    public $search;
    public $show = "add";


    public function  __construct() {

        //Middleware in another way
        if(auth()->user()->role_id ==3){

            $this->redirect("/Dashboard");
        }
    }



    public function render()
    {

        // $this->data = IMF::all();

        if($this->search == null){ //not searching
            $data = IMF::latest()->paginate(20);
        }else{//searching
            $data = IMF::where("id","like","%".$this->search."%")->paginate(10);
        }

        return view('livewire.dashboard.i-m-f',compact("data"));
    }


    public function saveOperation(){////   save operation  \\\\\

        $this->validate([
            "customer_id"=>"required|exists:customers,id",
            "operation_type"=>"required",
            "number"=>"required|numeric|min:1",
        ]);


        //customer data
        $customer = Customer::find($this->customer_id);

        //get the new number
        $this->newNumberOfAccount();
        //update the Account
        $customer->updateCostOfAccount($this->new_number);
        //save the operation
        IMF::create([
            'customer_id'=>$this->customer_id,
            'user_id'=>auth()->id(),
            'number'=>$this->number,
            'operation_type'=>$this->operation_type,
            'new_number'=>$this->new_number,
            'old_number'=>$this->old_number,
            'note'=>$this->note,
        ]);

        //success message
        session()->flash("msg_s","تم الاضافة بنجاح ");

        //reset data page
        $this->reset();
    }




    public function showUpdateForm($id){

        $this->imf_id = $id;
        $this->imf_data = IMF::find($id);// data of this operation

        //set data to vareable
        $this->customer_id = $this->imf_data->customer_id;
        $this->customer_name = $this->imf_data->customer()->name;
        $this->user_name = $this->imf_data->user()->name;
        $this->operation_type = $this->imf_data->operation_type;
        $this->new_number = $this->imf_data->new_number;
        $this->old_number = $this->imf_data->old_number;
        $this->number = $this->imf_data->number;
        $this->note = $this->imf_data->note;
        $this->show = "update";
    }



    public function updateOperation(){////   update operation  \\\\\

        $this->validate([
            "customer_id"=>"required|exists:customers,id",
            "operation_type"=>"required",
            "number"=>"required|numeric|min:1",
        ]);


        //customer data
        $customer = Customer::find($this->customer_id);


        //change the customer
        if($this->customer_id != $this->imf_data->customer_id){

            //old customer
            $old_customer =  Customer::find($this->imf_data->customer_id);

            if($this->imf_data->operation_type == "take"){// take operation
                //get cost of old customer
                $cost = $old_customer->account()->total_cost;
                //get a new cost
                $new_cost = $cost + $this->imf_data->number;
                //update the cost of old customer
                $old_customer->updateCostOfAccount($new_cost);

            }elseif($this->imf_data->operation_type == "give"){// give operation

                //get cost of customer
                $cost = $old_customer->account()->total_cost;
                //get a new cost
                $new_cost = $cost - $this->imf_data->number;
                //update the cost of customer
                $old_customer->updateCostOfAccount($new_cost);
            }else{
                return session()->flash("msg_e","يوجد خطا");
            }
        }else{//not change the customer

            //get old number from old record
            if($this->operation_type == "take"){
                $this->new_number = $this->imf_data->old_number - $this->number;
            }elseif($this->operation_type == "give"){
                $this->new_number = $this->imf_data->old_number + $this->number;
            }

            //update the Account
            $customer->updateCostOfAccount($this->new_number);
        }

        //update the operation
        $this->imf_data->update([
            'customer_id'=>$this->customer_id,
            'user_id'=>auth()->id(),
            'number'=>$this->number,
            'operation_type'=>$this->operation_type,
            'new_number'=>$this->new_number,
            'old_number'=>$this->old_number,
            'note'=>$this->note,
        ]);

        //success message
        session()->flash("msg_s","تم التعديل بنجاح ");

        //reset data page
        $this->reset();
    }


    public function showAdd(){

        $this->reset();
        $this->show = "add";
    }


    public function showIMFTable(){

        $this->reset();
        $this->show = "table";
    }

    public function showDeleteMessage($id){

        $this->imf_id = $id;
        $this->show = "delete";
    }


    public function imfDelete(){

        $data = IMF::find($this->imf_id);
        if($data){//the id is curect
            $customer = Customer::findOrFail($data->customer_id);
            if($data->operation_type == "take"){// take operation
                //get cost of customer
                $cost = $customer->account()->total_cost;
                //get a new cost
                $new_cost = $cost + $data->number;
                //update the cost of customer
                $customer->updateCostOfAccount($new_cost);

            }elseif($data->operation_type == "give"){// give operation

                //get cost of customer
                $cost = $customer->account()->total_cost;
                //get a new cost
                $new_cost = $cost - $data->number;
                //update the cost of customer
                $customer->updateCostOfAccount($new_cost);
            }else{
                return session()->flash("msg_e","يوجد خطا");
            }

            //delete
            $data->delete();

            //success message
            session()->flash("msg_s","تم الحذف بنجاح");

            //reset the imf_id
            $this->reset("imf_id");
            $this->show = "table";
        }else{
            $this->show = "table";
        }

    }

    public function setCustomerName(){//select customer name
        // dd($this->customer_name);
        if($this->customer_name){
            $this->customers = Customer::where("name","like",'%'.$this->customer_name.'%')->get();
            $this->side_bar = "show";
            $this->side_bar_customer_data = "customer list";
        }
    }


    public function setCustomer($id){//set customer data
        $customer = Customer::find($id);

        if($customer){
            $this->customer  = $customer;
            $this->customer_name = $customer->name;
            $this->customer_id = $id;
            $this->old_number = $customer->account()->total_cost;
            $this->side_bar_customer_data = "customer data";
        }

    }



    public function newNumberOfAccount(){///////   ///////
        if($this->number != 0 and $this->number != null){

            if($this->operation_type == "take"){
                $this->new_number = $this->old_number - $this->number;
            }elseif($this->operation_type == "give"){
                $this->new_number = $this->old_number + $this->number;
            }else{
                $this->new_number =0;
            }
        }else{
            $this->new_number =0;
        }

    }


    public function cancel(){

        $this->show = "table";
        $this->reset("customer_id","number","operation_type","new_number","old_number","note","customer_name","imf_id");
    }
}
