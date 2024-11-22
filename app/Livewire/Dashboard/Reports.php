<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\IMF;
use App\Models\Invoice;
use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Reports extends Component
{

    use WithPagination;
    #[Layout("layouts.dashboard")]



    public $report;
    public $type;
    public $date;
    public $sales_data;
    public $purchase_data;
    public $give_data;
    public $take_data;
    public $first_date;
    public $last_date;
    public $side_bar =false;
    public $side_bar_customer_data = "customer list";
    public $customers;
    public $customer;
    public $customer_name;
    public $customer_id;
    public $search = "";

    public $show = "reportList";

    public function  __construct() {

        //Middleware in another way
        if(auth()->user()->role_id !=1){

            $this->redirect("/Dashboard");
        }
    }
    public function render()
    {
        return view('livewire.dashboard.reports');
    }


// start invoices functions
    public function invoiceForDay(){

        $this->show = "invoice";
        $this->date = Carbon::today();

        $this->sales_data = Invoice::where("operation_type","out")->whereDate("created_at",$this->date)->get();
        $this->purchase_data = Invoice::where("operation_type","in")->whereDate("created_at",$this->date)->get();
    }



    public function byDurationForm(){
        $this->reset();
        $this->show = "invoiceByDuration";
    }



    public function byCustomerForm(){
        $this->reset();
        $this->show = "invoiceByCustomer";
    }



    public function invoiceByDuration(){
        $this->validate([
            "last_date" => "required|date",
        ]);

        $this->show = "invoice";

        if($this->first_date == null)
            $this->first_date = Carbon::today();

        $this->sales_data = Invoice::where("operation_type","out")->whereDate("created_at","<=",$this->first_date)->whereDate("created_at",">=",$this->last_date)->get();
        $this->purchase_data = Invoice::where("operation_type","in")->whereDate("created_at","<=",$this->first_date)->whereDate("created_at",">=",$this->last_date)->get();

        // dd($this->sales_data, $this->purchase_data);
    }



    public function invoiceByCustomer(){
        $this->validate([
            "customer_id" => "required",
        ]);

        $this->show = "invoice";

        if($this->first_date == null){
             $this->first_date = Carbon::today();
        }

        if($this->last_date == null){
            $this->last_date = Carbon::today();
       }


        $this->sales_data = Invoice::where("customer_id",$this->customer_id)->where("operation_type","out")->whereDate("created_at","<=",$this->first_date)->whereDate("created_at",">=",$this->last_date)->get();
        $this->purchase_data = Invoice::where("customer_id",$this->customer_id)->where("operation_type","in")->whereDate("created_at","<=",$this->first_date)->whereDate("created_at",">=",$this->last_date)->get();

        // dd($this->sales_data, $this->purchase_data);
    }
// end invoices functions




// start documents functions

    public function documentForDay(){

        $this->show = "document";
        $this->date = Carbon::today();

        $this->give_data = IMF::where("operation_type","give")->whereDate("created_at",$this->date)->get();//صرف
        $this->take_data = IMF::where("operation_type","take")->whereDate("created_at",$this->date)->get();//قبض
    }


    public function documentByDuration(){
        $this->validate([
            "last_date" => "required|date",
        ]);

        $this->show = "document";

        if($this->first_date == null)
            $this->first_date = Carbon::today();

            $this->give_data = IMF::where("operation_type","give")->whereDate("created_at","<=",$this->first_date)->whereDate("created_at",">=",$this->last_date)->get();
            $this->take_data = IMF::where("operation_type","take")->whereDate("created_at","<=",$this->first_date)->whereDate("created_at",">=",$this->last_date)->get();

        // dd($this->sales_data, $this->purchase_data);
    }

    public function documentByCustomer(){
        $this->validate([
            "customer_id" => "required",
        ]);

        $this->show = "document";

        if($this->first_date == null){
            $this->first_date = Carbon::today();
        }

        if($this->last_date == null){
            $this->last_date = Carbon::today();
       }


       $this->give_data = IMF::where("customer_id",$this->customer_id)->where("operation_type","give")->whereDate("created_at","<=",$this->first_date)->whereDate("created_at",">=",$this->last_date)->get();
       $this->take_data = IMF::where("customer_id",$this->customer_id)->where("operation_type","take")->whereDate("created_at","<=",$this->first_date)->whereDate("created_at",">=",$this->last_date)->get();

        // dd($this->sales_data, $this->purchase_data);
    }

    public function documentByDurationForm(){
        $this->reset();
        $this->show = "documentByDuration";
    }


    public function documentByCustomerForm(){
        $this->reset();
        $this->show = "documentByCustomer";
    }

// end documents functions



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
            $this->side_bar_customer_data = "customer data";
        }

    }

    public function cancel(){
        $this->reset();
    }
}
