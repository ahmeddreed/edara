<?php

namespace App\Livewire\Dashboard;

use App\Models\Store;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

class StoreTable extends Component
{
    use WithPagination;
    #[Layout("layouts.dashboard")]



    public $store_id;
    public $store_id_enc = "";
    public $store;
    public $name;
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
        $stores = $this->showData();
        return view('livewire.dashboard.store-table',compact("stores"));
    }


    public function showData(){///////// show defualt data ////////

       $data = Store::latest()->paginate(10);
       if($this->search){//searching

        $data = Store::where('name','like','%'.$this->search.'%')->paginate(10);
       }

       return $data;
    }


    public function showChange($name, $id = null,$enc =null){///////// show page section ////////

        if($name === "update" or $name === "delete" and $id != null and $enc != null){

            $this->store_id = $id;
            $this->store = Store::find($id);
            $this->name = $this->store->name;
            $this->show = $name;
            $this->store_id_enc = $enc;
        }elseif($name == "table" || $name == "add"){

            $this->show = $name;
        }else{

            $this->show = "table";
        }

    }





    public function create(){//////create store //////

        //validate of data
        $this->validate([
            'name'=>'required|string|unique:stores',
        ]);


        //insert data
        $role = Store::create([
            'name'=>$this->name,
            'user_id'=>auth()->id(),
        ]);

        //success message
        session()->flash("msg_s","تم الانشاء بنجاح");

        //reset the data
        $this->reset();

    }



    public function update(){//////update store //////


        //validate of data
        $this->validate([
            'name'=>'required|string',
        ]);

        //insert data
        $store = $this->store;

        // if($store->id != auth()->id()){

        //     //error message
        //     return session()->flash("msg_e","انت ليس المنشاء للمخزن");
        // }

        $store->update([
            'name'=>$this->name,
            'user_id'=>auth()->id(),
        ]);

        //save the change
        $this->store->save();

        //success message
        session()->flash("msg_s","تم التحديث بنجاح");

        //reset the data
        $this->reset();

    }






    public function delete(){

        //check the encrypt value
        if(Hash::check($this->store_id,$this->store_id_enc)){

            //get the data
            $store = $this->store;

            //delete store
            $store->delete();

            //success message
            session()->flash("msg_s","تم الحذف بنجاح");

            //reset the data
            $this->reset();
        }else{

             //error message
             session()->flash("msg_s"," التشفير غير مطابق");
        }
    }



    public function cancel(){///////reset data//////

        $this->reset();
    }
}
