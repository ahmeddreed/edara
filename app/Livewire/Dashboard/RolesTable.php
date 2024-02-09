<?php

namespace App\Livewire\Dashboard;

use App\Models\Role;
use GuzzleHttp\Middleware;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class RolesTable extends Component
{
    use WithPagination;
    #[Layout("layouts.dashboard")]



    public $role_id;
    public $role_id_enc = "";
    public $role;
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
        $roles = $this->showData();
        return view('livewire.dashboard.roles-table',compact("roles"));
    }


    public function showData(){///////// show defualt data ////////

       $data = Role::latest()->paginate(10);
       if($this->search){//searching

        $data = Role::where('name','like','%'.$this->search.'%')->paginate(10);
       }

       return $data;
    }


    public function showChange($name, $id = null,$enc =null){///////// show page section ////////

        if($name === "update" or $name === "delete" and $id != null and $enc != null){

            $this->role_id = $id;
            $this->role = Role::find($id);
            $this->name = $this->role->name;
            $this->show = $name;
            $this->role_id_enc = $enc;
        }elseif($name == "table" || $name == "add"){

            $this->show = $name;
        }else{

            $this->show = "table";
        }

    }





    public function create(){//////create role //////

        //validate of data
        $this->validate([
            'name'=>'required|string|unique:roles',
        ]);


        //insert data
        $role = Role::create([
            'name'=>$this->name,
        ]);

        //success message
        session()->flash("msg_s","تم الانشاء بنجاح");

        //reset the data
        $this->reset();

    }



    public function update(){//////update role //////

        //validate of data
        $this->validate([
            'name'=>'required|string',
        ]);

        //insert data

        $role = $this->role;

        $role->update([
            'name'=>$this->name,
        ]);

        //save the change
        $this->role->save();

        //success message
        session()->flash("msg_s","تم التحديث بنجاح");

        //reset the data
        $this->reset();

    }






    public function delete(){

        //check the encrypt value
        if(Hash::check($this->role_id,$this->role_id_enc)){

            //get the data
            $role = $this->role;

            //delete role
            $role->delete();

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
