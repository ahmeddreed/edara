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
    public $show = "table";



    public function  __construct() {

        //Middleware in another way
        if(auth()->user()->role_id !=1){

            $this->redirect("/Dashboard");
        }
    }



    public function render(){

        if($this->search == null){ //not searching
            $invoices = Invoice::latest()->paginate(20);
        }else{//searching
            $invoices = Invoice::where("id","like","%".$this->search."%")->paginate(10);
        }

        return view('livewire.dashboard.invoice-processing',compact("invoices"));
    }

    public function showChange($name, $id){/////////show page section////////

        $this->invoice_id = $id;
        $this->invoice = Invoice::findOrFail($id);
        $this->show = $name;

    }


    public function equip(){/////////equip the invoice////////

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

        //get the invoice
        $dataOfInvoice = DataOfInvoice::findOrFail($item_id);
        //set the data
        $dataOfInvoice->equip =!$dataOfInvoice->equip;
        //update data
        $dataOfInvoice->update();
    }



   public function cancel(){// reset data

    $this->reset();
   }

}
