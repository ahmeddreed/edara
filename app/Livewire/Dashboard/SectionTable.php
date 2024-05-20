<?php

namespace App\Livewire\Dashboard;

use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

class SectionTable extends Component
{

    use WithPagination;
    #[Layout("layouts.dashboard")]


    public $section_id;
    public $section_id_enc = "";
    public $section;
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

        $sections = $this->showData();
        return view('livewire.dashboard.section-table',compact("sections"));
    }


    public function showData(){///////// show defualt data ////////

        $data = Section::latest()->paginate(10);
        if($this->search){//searching

         $data = Section::where('name','like','%'.$this->search.'%')->paginate(10);
        }

        return $data;
     }


     public function showChange($name, $id = null,$enc =null){///////// show page section ////////

         if($name === "update" or $name === "delete" and $id != null and $enc != null){

            $this->section_id = $id;
            $this->section = Section::find($id);
            $this->name = $this->section->name;
            $this->section_id_enc = $enc;
            $this->show = $name;
         }elseif($name == "table" || $name == "add"){

            $this->show = $name;
         }else{

            $this->show = "table";
         }

     }





     public function create(){//////create section //////

         //validate of data
         $this->validate([
            'name'=>'required|string|unique:sections',
         ],[
            "name.required"=>"الاسم مطلوب",
            "name.string"=>"يجب ان يكون الاسم نص",
            "name.unique"=>"الاسم محجوز",
         ]);


         //insert data
         $section = Section::create([
            'name'=>$this->name,
         ]);

         //success message
         session()->flash("msg_s","تم الانشاء بنجاح");

         //reset the data
         $this->reset();

     }



     public function update(){//////update section //////

         //validate of data
         $this->validate([
            'name'=>'required|string',
        ],[
            "name.required"=>"الاسم مطلوب",
            "name.string"=>"يجب ان يكون الاسم نص",
        ]);


        $section = $this->section;
        $nameCount = Section::where("name",$this->name)->count();

        //the name is existe
        if($nameCount > 0 and $this->name != $section->name){

            return session()->flash('error','هذا الاسم محجوز');
        }else{
            //insert data
            $section->update([
                'name'=>$this->name,
            ]);

            //save the change
            $this->section->save();

            //success message
            session()->flash("msg_s","تم التحديث بنجاح");

            //reset the data
            $this->reset();
        }
     }






     public function delete(){

         //check the encrypt value
         if(Hash::check($this->section_id,$this->section_id_enc)){

             //get the data
             $section = $this->section;

             //delete section
             $section->delete();

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