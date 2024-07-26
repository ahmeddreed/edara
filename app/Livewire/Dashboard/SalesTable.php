<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use App\Models\Store;
use App\Models\Invoice;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Material;
use Livewire\WithPagination;
use App\Models\DataOfInvoice;
use Livewire\WithFileUploads;
use App\Models\CustomerAccount;
use App\Models\DelegateAccount;
use Livewire\Attributes\Layout;
use App\Models\NumberOfMaterial;
use App\Models\ConfirmTheInvoice;

class SalesTable extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Layout("layouts.dashboard")]


    //invoice fields
    public $date;
    public $all_invoice = false;
    public $invoice;
    public $invoice_id;
    public $invoice_id_enc;
    public $invoice_total_cost = 0;
    public $invoice_type;
    public $operation_type;
    public $t_price;
    public $invoice_note;
    public $invoice_material_count = 0;
    public $invoice_items;
    public $invoice_equipper;
    public $equippers;
    public $invoice_verify = true;
    public $user_id;
    public $discount = 0;
    public $side_bar = "hide";
    public $side_bar_customer_data = "customer list";

    //material fields
    public $material_id;
    public $material_name;
    public $materials;
    public $material;
    public $material_price = 0;
    public $material_sale_price;
    public $material_Qty;
    public $material_total_cost;
    public $material_expiration;
    public $material_note;
    public $side_bar_material_data = "material list";

    public $stores;
    public $store_id;

    public $customer_name;
    public $customer_id;
    public $search;
    public $customer;
    public $customers;
    public $show = "table";
    public $item_id;


    public function  __construct() {

        //Middleware in another way
        if(auth()->user()->role_id == 3){

            $this->redirect("/Dashboard");
        }
    }

    public function render(){

        $this->equippers = User::where("role_id",3)->get();
        $this->stores = Store::all();

        if($this->date == null){//set date

            $this->date = now()->format("Y-m-d");
        }

        if($this->search == null){ //not searching

            if(auth()->user()->role_id == 1)//manager
                $data = Invoice::where("created_at","like","%".$this->date."%")->paginate(10);
            else//staff
                $data = Invoice::where("user_id",auth()->id())->where("created_at","like","%".$this->date."%")->paginate(10);

        }else{//searching

            if(auth()->user()->role_id == 1)//manager
                $data = Invoice::where("id","like","%".$this->search."%")->paginate(10);
            else//staff
                $data = Invoice::where("user_id",auth()->id())->where("id","like","%".$this->search."%")->paginate(10);
        }

        //if select all
        if($this->all_invoice == true){
            if(auth()->user()->role_id == 1)//manager
                $data = Invoice::latest()->paginate(20);
            else//staff
                $data = Invoice::where("user_id",auth()->id())->paginate(20);

        }

        return view('livewire.dashboard.sales-table',compact("data"));
    }



    public function showInvoiceDetail($invoice_id){// show a invoice detail
        $invoice = Invoice::find($invoice_id);
        //invoice data
        $this->invoice = $invoice;
        $this->invoice_id = $invoice->id;
        $this->invoice_items = $invoice->items();
        $this->invoice_type = $invoice->invoice_type;
        $this->operation_type = $invoice->operation_type;
        $this->invoice_equipper = $invoice->equipper;

        //customer data
        $this->customer_id = $invoice->customer_id;
        $this->customer = Customer::find($this->customer_id);
        $this->customer_name = $this->customer->name;
        $this->side_bar_customer_data = "customer data";

        $this->side_bar = "show";

        // set data of invoice material count
        $this->invoice_material_count = $this->materialCount();
        // set data of invoice total cost
        $this->invoice_total_cost = $this->totalPriceOfItem();

        $this->show = "add";
    }


    public function createNewInvoice(){// create invoice

        // create a new invoice
        $newInvoice = Invoice::create([
            "user_id" => auth()->id(),
        ]);

        //verify the invoice
        $verifyTheInvoice = ConfirmTheInvoice::create([
            "invoice_id" => $newInvoice->id,
            "invoice_verify" => $this->invoice_verify,
        ]);

        //set data
        $this->invoice = $newInvoice;
        $this->invoice_id = $newInvoice->id;
        $this->invoice_items = $newInvoice->items();
        $this->show = "add";
    }


    public function showDelete($invoice_id){//delete a invoice
        $invoice = Invoice::find($invoice_id);
        if($invoice){
            $this->invoice_id = $invoice->id;
            $this->customer_id = $invoice->customer_id;
            $this->show = "delete";
        }
    }

    public function invoiceDelete(){//delete a invoice
        //customer data
        $customer = Customer::find($this->customer_id);
        //invoice data
        $invoice = Invoice::find($this->invoice_id);

        //low the value of account of this customer
        $costValue = $customer->account()->total_cost - $invoice->t_price_after_discount;

        //update the account value
        $customer->updateCostOfAccount($costValue);

        //delete the invoice
        $invoice->delete();

        //reset page
        $this->reset();
    }

    public function addItem(){//set item to invoice

        $this->validate([//validate data
            'material_name' => 'required',
            'customer_name' => 'required',
            'invoice_type' => 'required',
            'operation_type' => 'required',
            'store_id' => 'required',
            'material_Qty' => 'required|numeric|min:1',
            'material_price' => 'nullable|numeric',
            'material_sale_price' => 'required|numeric|min:1',
            'material_expiration' => 'nullable',
            'material_note' => 'nullable',
            'invoice_note' => 'nullable',
            'discount' => 'nullable',
        ]);



        if($this->operation_type == "out"){// in operation

            $cost_of_all = $this->material_sale_price * $this->material_Qty;
        }elseif($this->operation_type == "in"){// out operation
            if($this->material_price == 0 or $this->material_price == null){

                return session()->flash("msg_e","الرجاء ادخال سعر المادة");
            }

            $cost_of_all = $this->material_price * $this->material_Qty;
        }

        //change material count in store
        $this->changeMaterialCountInStore();

        //item data
        $item = [
            "invoice_id" => $this->invoice_id,
            "material_id" => $this->material_id,
            "Qty" => $this->material_Qty,
            "price" => $this->material_price,
            "sale_price" => $this->material_sale_price,
            "cost_of_all" => $cost_of_all,
            "expiration" => $this->material_expiration,
            "store_id" => $this->store_id,
            "note" => $this->material_note,
        ];

        //save the item and set it to the component property
        $createItem = DataOfInvoice::create($item);

        // set data of invoice material count
        $this->invoice_material_count = $this->materialCount();
        // set data of invoice total cost
        $this->invoice_total_cost = $this->totalPriceOfItem();

        $this->reset("material_id","material_Qty","material_price","material_total_cost","material_name","material_expiration");
        return session()->flash("msg_s","تم اضافة العنصر بنجاح");
    }



    public function updateItem($item_id){//set item to invoice

        $this->validate([//validate data
            'material_name' => 'required',
            'customer_name' => 'required',
            'invoice_type' => 'required',
            'store_id' => 'required|exsit:stores',
            'operation_type' => 'required',
            'material_Qty' => 'required|numeric|min:1',
            'material_price' => 'nullable|numeric',
            'material_sale_price' => 'required|numeric|min:1',
            'material_note' => 'nullable',
            'material_expiration' => 'nullable',
            'invoice_note' => 'nullable',
            'discount' => 'nullable',
        ]);

        //operation type
        if($this->operation_type == "out"){
            $cost_of_all = $this->material_sale_price * $this->material_Qty;
        }elseif($this->operation_type == "in"){//change to in operation

            if($this->material_price == 0 or $this->material_price == null){

                return session()->flash("msg_e","الرجاء ادخال سعر المادة");
            }
            $cost_of_all = $this->material_price * $this->material_Qty;
        }


        //change material count in store
        $this->changeMaterialCountInStore();


        //item data
        $item = [
            "invoice_id" => $this->invoice_id,
            "material_id" => $this->material_id,
            "Qty" => $this->material_Qty,
            "price" => $this->material_price,
            "sale_price" => $this->material_sale_price,
            "cost_of_all" => $cost_of_all,
            "expiration" => $this->material_expiration,
            'store_id' =>$this->store_id,
            "note" => $this->material_note,
        ];

        //save the item and set it to the component property
        $updateItem = DataOfInvoice::find($item_id)->update($item);

        // set data of invoice material count
        $this->invoice_material_count = $this->materialCount();

        // set data of invoice total cost
        $this->invoice_total_cost = $this->totalPriceOfItem();
        $this->reset("item_id","material_id","material_Qty","material_price","material_total_cost","material_name");
        return session()->flash("msg_s","تم التحديث العنصر بنجاح");
    }



    public function editItem($itme_id){// edit item of invoice
        $itemData = DataOfInvoice::find($itme_id);
        $this->item_id = $itemData->id;
        $this->material_id  = $itemData->material_id ;
        $this->material_Qty  = $itemData->Qty ;
        $this->material_price = $itemData->price;
        $this->material_total_cost = $itemData->cost_of_all;
        $this->material_expiration = $itemData->expiration;
        $this->material_note = $itemData->note;
        $this->store_id = $itemData->store_id;
        $this->material_name = $itemData->material()->title;
    }



    public function deleteItem($itme_id){//delete item of invoice
        DataOfInvoice::find($itme_id)->delete();
    }





    public function saveTheInvoice(){//save the invoice

        $this->validate([//validate data
            'customer_name' => 'required',
            'invoice_equipper' => 'required',
            'invoice_type' => 'required',
            'operation_type' => 'required',
            'invoice_note' => 'nullable',
            'discount' => 'nullable',
        ]);



        //get total cost
        $totalCost = $this->totalPriceOfItem();
        //get material count
        $materialCount = $this->materialCount();

        $totalCostAfterDiscount = $totalCost - $this->discount;
        $customer = Customer::find($this->customer_id);

        //update data of invoice
        $invoice = Invoice::findOrFail($this->invoice_id);


        if($this->operation_type != $invoice->operation_type and $invoice->operation_type != null){//if change the operation type
            // if($this->operation_type == "in"){//in operation
            //     $this->onChangeInOperation();
            // }elseif($this->operation_type == "out"){//out operation
            //     $this->onChangeOutOperation();
            // }else{
            //     //another value
            // }

            //يتم العمل عليه في ما بعد
            return session()->flash("msg_e","عذرا لا يمكن تغيير نوع العملية بعد ");


        }elseif($this->invoice_type != $invoice->invoice_type and $invoice->invoice_type != null and $invoice->operation_type != null){ //if change the invoice type
            if($this->invoice_type == "cash"){//cash invoice

                //low the value of account of this customer
                $costValue = $customer->account()->total_cost + $this->invoice->t_price_after_discount;

                //update the account value
                $customer->updateCostOfAccount($costValue);
            }elseif($this->invoice_type == "debt"){//debt invoice

                //low the value of account of this customer
                $costValue = $customer->account()->total_cost - $this->invoice->t_price_after_discount;

                //update the account value
                $customer->updateCostOfAccount($costValue);
            }else{
                //another value
            }
        }else{
            //another value
        }


        //change the customer => the case is update
        if($this->customer_id != $invoice->customer_id and $invoice->customer_id != null){

            if($this->invoice_type != $invoice->invoice_type and $invoice->invoice_type != null){
                //change customer function
                $this->onChangeCustomer();
            }else{
                if($this->invoice_type == "debt"){// only debt case
                    //for old customer
                    $oldCustomer = Customer::find($invoice->customer_id);
                    $totalCostForOld = $oldCustomer->account()->total_cost - $invoice->t_price_after_discount;
                    $oldCustomer->updateCostOfAccount($totalCostForOld);

                    $totalCost = $oldCustomer->account()->total_cost + $invoice->t_price_after_discount;
                    $customer->updateCostOfAccount($totalCost);
                }

            }

        }elseif($invoice->customer_id == null){//the case is create

            $newCost = 0;

            //the customer not have an account
            if($customer->account() == null){
                //create a new account for the customer
                CustomerAccount::create([
                    'customer_id' => $customer->customer_id,
                ]);
                //total cost is by defualt 0
            }


            //customer Account
            $customerAccount = CustomerAccount::where("customer_id",$this->customer_id)->first();

            if($this->invoice_type == "debt"){
                if($this->operation_type == "in")
                    $newCost = $customerAccount->total_cost - $totalCost;
                elseif($this->operation_type == "out")
                    $newCost = $customerAccount->total_cost + $totalCost;

                //update the cost value
                $customer->updateCostOfAccount($newCost);
            }


        }


        //In case change anything
        if($invoice->t_price_after_discount != $totalCostAfterDiscount || $invoice->material_count != $materialCount and $invoice->customer_id != null and $this->operation_type == "debt"){
            //new total cost of customer
            $newTotalCost = $customer->account()->total_cost + ($totalCostAfterDiscount - $invoice->t_price_after_discount);

            //update total cost for this customer
            CustomerAccount::where('customer_id',$this->customer_id)
            ->update([
                'total_cost'=>$newTotalCost,
            ]);
        }



        $invoice->customer_id = $this->customer_id;
        $invoice->equipper = $this->invoice_equipper;
        $invoice->discount = $this->discount;
        $invoice->invoice_type = $this->invoice_type;
        $invoice->operation_type = $this->operation_type;
        $invoice->material_count = $materialCount;
        $invoice->t_price = $totalCost;
        $invoice->t_price_after_discount = $totalCost - $this->discount;
        $invoice->note = $this->invoice_note;

        //save change
        $invoice->update();

        //verify the invoice if it not verify
        if(!$invoice->confirm()->invoice_verify){
            $confirmTheInvoice = ConfirmTheInvoice::where("invoice_id",$invoice->id)->first();
            $confirmTheInvoice->invoice_Verify = $this->invoice_verify;
            $confirmTheInvoice->update();
        }


        //the delegate
        if(auth()->user()->role_id == 4){

            $user = User::find(auth()->id());
            if(!$user->check_invoice($this->invoice_id)){//if not exsits
                //add to delegate account table
                DelegateAccount::create([
                                    "user_id"=>$user->id,
                                    "invoice_id"=>$this->invoice_id,
                                    ]);
            }
        }



        $this->reset();
        $this->show = "table";
        session()->flash("msg_s","تم اضافة العنصر بنجاح");

    }



    public function onChangeCustomer(){
        //old customer
        $oldCustomer = Customer::find($this->invoice->customer_id);
        //new customer
        $newCustomer = Customer::find($this->customer_id);

        //the new customer not have an account
        if($newCustomer->account() == null){
            $customerAccount =CustomerAccount::create([
                'customer_id' => $this->customer_id ,
            ]);
        }

        if($this->invoice_type == "cash"){//cash invoice

            //low the value of cost of this customer
            $costValue = $oldCustomer->account()->total_cost - $this->invoice->t_price_after_discount;
            //update the cost value
            $oldCustomer->updateCostOfAccount($costValue);

        }elseif($this->invoice_type == "debt"){//debt invoice

            //low the cost of account of old customer
            $costValue = $oldCustomer->account()->total_cost - $this->invoice->t_price_after_discount;
            //update the cost value
            $oldCustomer->updateCostOfAccount($costValue);

            //add the value of cost of new customer
            $costValue = $newCustomer->account()->total_cost + $this->invoice->t_price_after_discount;
            //update the cost value
            $newCustomer->updateCostOfAccount($costValue);
        }else{
            //another value
        }
    }



    public function onChangeInOperation(){
        //customer data
        $customer = Customer::find($this->customer_id);
        //invoice data
        $invoice = Invoice::findOrFail($this->invoice_id);

        if($this->invoice_type != $invoice->invoice_type and $invoice->invoice_type != null){//change the invoice type
            if($this->invoice_type == "cash"){
                //low the value of account of this customer
                $costValue = $customer->account()->total_cost + $this->invoice->t_price_after_discount;

                //update the account value
                $customer->updateCostOfAccount($costValue);
            }elseif($this->invoice_type == "debt"){
                //low the value of account of this customer
                $costValue = $customer->account()->total_cost - $this->invoice->t_price_after_discount;

                //update the account value
                $customer->updateCostOfAccount($costValue);
            }else{
                //another value
            }

        }elseif($this->invoice_type == $invoice->invoice_type and $invoice->invoice_type != null){//change the invoice type
            if($this->invoice_type == "debt"){
                //low the value of account of this customer
                $costValue = $customer->account()->total_cost - $this->invoice->t_price_after_discount;

                //update the account value
                $customer->updateCostOfAccount($costValue);
            }else{
                //another value
            }
        }else{
            ////another value
        }
    }


    public function onChangeOutOperation(){

        //customer data
        $customer = Customer::find($this->customer_id);
        //invoice data
        $invoice = Invoice::findOrFail($this->invoice_id);

        if($this->invoice_type != $invoice->invoice_type and $invoice->invoice_type != null){//change the invoice type
            if($this->invoice_type == "cash"){
                //low the value of account of this customer
                $costValue = $customer->account()->total_cost - $this->invoice->t_price_after_discount;

                //update the account value
                $customer->updateCostOfAccount($costValue);
            }elseif($this->invoice_type == "debt"){
                //low the value of account of this customer
                $costValue = $customer->account()->total_cost + $this->invoice->t_price_after_discount;

                //update the account value
                $customer->updateCostOfAccount($costValue);
            }else{
                //another value
            }

        }elseif($this->invoice_type == $invoice->invoice_type and $invoice->invoice_type != null){//change the invoice type
            if($this->invoice_type == "debt"){
                //low the value of account of this customer
                $costValue = $customer->account()->total_cost + $this->invoice->t_price_after_discount;

                //update the account value
                $customer->updateCostOfAccount($costValue);
            }else{
                //another value
            }
        }else{
            ////another value
        }
    }


    public function operationsOnAccountOfCustomer($invoice,$totalCostAfterDiscount,$materialCount){//change the customer of invoice and change the customer account

        //dont change the customer
        if($invoice->customer_id == $this->customer_id){

            //get old total cost of customer
            $customerAccount = CustomerAccount::where('customer_id',$invoice->customer_id)->first();

            if($customerAccount == null){
                $customerAccount =CustomerAccount::create([
                    'customer_id' => $this->customer_id ,
                ]);

               if($this->invoice_type == "debt"){//debt invoice
                    //customer data
                    $customer = Customer::find($this->customer_id);

                    //low the value of account of this customer
                    $costValue = $customer->account()->total_cost + $this->invoice->t_price_after_discount;

                    //update the account value
                    $customer->updateCostOfAccount($costValue);
                }
            }

            //In case change anything
            if($invoice->t_price_after_discount != $totalCostAfterDiscount || $invoice->material_count != $materialCount){
                //new total cost of customer
                $newTotalCost = $customerAccount->total_cost + ($totalCostAfterDiscount - $invoice->t_price_after_discount);

                //update new total cost for this customer
                CustomerAccount::where('customer_id',$this->customer_id)
                ->update([
                    'total_cost'=>$newTotalCost,
                ]);
            }


        }elseif($invoice->customer_id != $this->customer_id and $invoice->customer_id != null){//change the customer

            // account of old customer
            $accountOfOldCustomer = CustomerAccount::where('customer_id',$invoice->customer_id)->first();
            // account of new customer
            $accountOfNewCustomer = CustomerAccount::where('customer_id',$this->customer_id)->first();

            //this customer not have an account
            if($accountOfNewCustomer == null){
                $accountOfNewCustomer =CustomerAccount::create([
                    'customer_id' => $this->customer_id ,
                ]);
            }

            //remove  amount of old customer
            $accountOfOldCustomer->total_cost = $accountOfOldCustomer->total_cost - $invoice->t_price_after_discount;
            $accountOfOldCustomer->update();

            //add  amount of new customer
            $accountOfNewCustomer->total_cost = $accountOfNewCustomer->total_cost + $invoice->t_price_after_discount;
            $accountOfNewCustomer->update();


        }else{
            //new set
        }
    }



    public function totalPriceOfItem(){//get count of material
        $itemsOfInvoice = DataOfInvoice::where("invoice_id",$this->invoice_id)->get();
        $totalPrice=0 ;
        foreach ($itemsOfInvoice as $item) {
            $totalPrice += $item->cost_of_all;
        }

        return $totalPrice;
    }



    public function materialCount(){//get count of material
        $itemsOfInvoice = DataOfInvoice::where("invoice_id",$this->invoice_id)->get();
        $totalMaterial=0 ;
        foreach ($itemsOfInvoice as $item) {
            $totalMaterial += $item->Qty;
        }

        return $totalMaterial;
    }


    public function changeMaterialCountInStore(){
        $itemsOfInvoice = NumberOfMaterial::where("material_id",$this->material_id)->first();
        $invoice = Invoice::find($this->invoice_id);
        $item = DataOfInvoice::find($this->item_id);

        if(!$itemsOfInvoice){//create case
            NumberOfMaterial::create([
                "material_id"=>$this->material_id,
                // "user_id"=>auth()->id(),
            ]);
        }


        if($item == null){//create case

            if($this->operation_type == "in"){// in operation

                $itemsOfInvoice->number += $this->material_Qty;
            }elseif($this->operation_type == "out"){// out operation

                $itemsOfInvoice->number -= $this->material_Qty;
            }
        }else{// update case

            if($this->operation_type != $invoice->operation_type ){//change the operation type/ update cas

                if($this->operation_type == "in"){// in operation

                    $itemsOfInvoice->number -= $item->Qty;
                    $itemsOfInvoice->number += $this->material_Qty;
                }elseif($this->operation_type == "out"){// out operation

                    $itemsOfInvoice->number += $item->Qty;
                    $itemsOfInvoice->number -= $this->material_Qty;
                }

            }elseif($item->Qty != $this->material_Qty){//change the Qty/ update case

                $new_number = $item->Qty - $this->material_Qty;
                if($this->operation_type == "in"){// in operation

                    $itemsOfInvoice->number -= $new_number;
                }elseif($this->operation_type == "out"){// out operation

                    $itemsOfInvoice->number += $new_number;
                }

            }


        }


        // if($invoice->operation_type == null){//create case

            // if($this->operation_type == "in"){// in operation

            //     $itemsOfInvoice->number += $this->material_Qty;
            // }elseif($this->operation_type == "out"){// out operation

            //     $itemsOfInvoice->number -= $this->material_Qty;
            // }

        // }elseif($this->operation_type != $invoice->operation_type and $this->operation_type != null){//change the operation type/ update cas

        //     if($this->operation_type == "in"){// in operation

        //         $itemsOfInvoice->number -= $item->Qty;
        //         $itemsOfInvoice->number += $this->material_Qty;
        //     }elseif($this->operation_type == "out"){// out operation

        //         $itemsOfInvoice->number += $item->Qty;
        //         $itemsOfInvoice->number -= $this->material_Qty;
        //     }

        // }else{//change the Qty/ update case

        //     if($item->Qty != $this->material_Qty){

        //         $new_number = $item->Qty - $this->material_Qty;
        //         if($this->operation_type == "in"){// in operation

        //             $itemsOfInvoice->number -= $new_number;
        //         }elseif($this->operation_type == "out"){// out operation

        //             $itemsOfInvoice->number += $new_number;
        //         }
        //     }

        // }


        $itemsOfInvoice->update();
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
            $this->side_bar_customer_data = "customer data";
        }

    }



   public function setMaterialName(){//select material name{
        // dd($this->customer_name);
        if($this->material_name){
            $this->materials = Material::where("title","like",'%'.$this->material_name.'%')->get();
            $this->side_bar = "show";
            $this->side_bar_material_data = "material list";
        }
    }



    public function setMaterial($id){//set Material data
        $material = Material::find($id);

        if($material){
            // dd($material->salePrice());
            $this->material  = $material;
            $this->material_name = $material->title;
            $this->material_id = $id;
            $this->side_bar_material_data = "material data";

            //count of cost
            // $this->material_price = $material->price;
            $this->material_Qty = 0;
            $this->material_sale_price = $material->salePrice();
            $this->material_total_cost = $this->material_Qty * $this->material_price;
        }

    }


    public function totalCost(){//count of cost
        if($this->operation_type == "in"){

            if($this->material_Qty != null and $this->material_price !=null){
                $this->material_total_cost = $this->material_Qty * $this->material_price;
            }else{
                $this->material_total_cost = 0;
            }
        }elseif($this->operation_type == "out"){

            if($this->material_Qty != null and $this->material_sale_price !=null){
                $this->material_total_cost = $this->material_Qty * $this->material_sale_price;
            }else{
                $this->material_total_cost = 0;
            }
        }

    }





    public function out(){

        if(count($this->invoice->items()) == 0){

            $invoice = Invoice::find($this->invoice_id);
            if($invoice)
                $invoice->delete();
        }elseif($this->invoice->customer_id != null and $this->invoice->invoice_type != null and $this->operation_type != null){
            $this->reset();
        }else{
            return session()->flash("msg_e","الرجاء حفظ الفاتورة");
        }

        $this->reset();

    }


    public function cancel(){

        $this->reset();
    }
}
