<?php

namespace App\Livewire\Dashboard;

use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DataOfInvoice;
use Livewire\Attributes\Layout;
use App\Models\ConfirmTheInvoice;

class InvoiceProcessing extends Component
{
    use WithPagination;

    #[Layout("layouts.dashboard")]

    public $invoice;
    public $invoice_id;
    public $operations;
    public $equip_item;
    public $search;
    public $date;
    public $all_invoice = false;
    public $show = "table";



    public function  __construct() {
        //
    }



    public function render(){

        if($this->date == null){//set date

            $this->date = now()->format("Y-m-d");
        }

        if($this->search == null){ //not searching

            if(auth()->user()->role_id != 3)//manager and assistant
                $invoices = Invoice::where("created_at","like","%".$this->date."%")->paginate(10);
            else//staff
                $invoices = Invoice::where("equipper",auth()->id())->where("created_at","like","%".$this->date."%")->paginate(10);

        }else{//searching

            if(auth()->user()->role_id != 3)//manager and assistant
                $invoices = Invoice::where("id","like","%".$this->search."%")->paginate(10);
            else//staff
                $invoices = Invoice::where("equipper",auth()->id())->where("id","like","%".$this->search."%")->paginate(10);
        }

        //if select all
        if($this->all_invoice == true){
            if(auth()->user()->role_id != 3)//manager and assistant
                $invoices = Invoice::latest()->paginate(20);
            else//staff
                $invoices = Invoice::where("equipper",auth()->id())->paginate(20);

        }

        // if($this->search == null){ //not searching
        //     $invoices = Invoice::latest()->paginate(20);
        // }else{//searching
        //     $invoices = Invoice::where("id","like","%".$this->search."%")->paginate(10);
        // }

        return view('livewire.dashboard.invoice-processing',compact("invoices"));
    }

    public function showChange($name, $id){/////////show page section////////

        $this->invoice_id = $id;
        $this->invoice = Invoice::findOrFail($id);
        $this->show = $name;

    }


    public function equip(){/////////equip the invoice////////

        if(auth()->user()->role_id != 3){
            //erorr message
            return session()->flash("msg_e","ليس من صلاحياتك التجهيز");
        }

        $equipped = ConfirmTheInvoice::where("invoice_id",$this->invoice_id)->first();
        $invoice = Invoice::findOrFail($this->invoice_id);

        if($equipped){
            if($invoice->equipinvoice()){
                //equip = true
                $equipped->equip = !$equipped->equip;

                //update data
                $equipped->update();

                //success message
                session()->flash("msg_s","تم العملية بنجاح");

                //reset the data
                $this->reset();
            }else{
                //error message
                session()->flash("msg_e","ليس كل العناصر مجهزة" );
            }
        }else{
            //error message
            session()->flash("msg_e","عذرا يوجد خطا");
        }

    }

    public function equipItem($item_id){/////////equip the invoice////////
        if(auth()->user()->role_id != 3){
            //erorr message
            return session()->flash("msg_e","ليس من صلاحياتك التجهيز");
        }

        $equipped = ConfirmTheInvoice::where("invoice_id",$this->invoice_id)->first();
        if($equipped->equip == false){
            //get the invoice
            $dataOfInvoice = DataOfInvoice::findOrFail($item_id);
            //set the data
            $dataOfInvoice->equip =!$dataOfInvoice->equip;
            //update data
            $dataOfInvoice->update();
        }else{
            //erorr message
            return session()->flash("msg_e","تم التجهيز القائمة من قبل");
        }

    }



   public function cancel(){// reset data

    $this->reset();
   }

}
