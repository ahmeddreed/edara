<?php

namespace App\Livewire\Dashboard;

use App\Models\Section;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

class CategoryTable extends Component
{
    use WithPagination;
    #[Layout("layouts.dashboard")]




    public $section_id;
    public $category_id_enc = "";
    public $category;
    public $name;
    public $category_id;
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

        $categories = $this->showData();
        $sections = Section::all();
        return view('livewire.dashboard.category-table',compact("categories","sections"));
    }


    public function showData(){///////// show defualt data ////////

        $data = Category::latest()->paginate(10);
        if($this->search){//searching

         $data = Category::where('name','like','%'.$this->search.'%')->paginate(10);
        }

        return $data;
     }


     public function showChange($name, $id = null,$enc =null){///////// show page category ////////

         if($name === "update" or $name === "delete" and $id != null and $enc != null){

            $this->category_id = $id;
            $this->category = Category::find($id);
            $this->name = $this->category->name;
            $this->section_id = $this->category->section_id;
            $this->category_id_enc = $enc;
            $this->show = $name;
         }elseif($name == "table" || $name == "add"){

            $this->show = $name;
         }else{

            $this->show = "table";
         }

     }





     public function create(){//////create category //////

         //validate of data
         $this->validate([
            'name'=>'required|string|unique:categories',
            'section_id'=>'required|exists:sections,id',
        ],[
            "name.required"=>"الاسم مطلوب",
            "name.string"=>"يجب ان يكون الاسم نص",
            "name.unique"=>"الاسم محجوز",
            "section_id.required"=>"القسم مطلوب",
            "section_id.exists"=>"القسم غير موجود",
        ]);


         //insert data
         $category = Category::create([
            'name'=>$this->name,
            'section_id'=>$this->section_id,
         ]);

         //success message
         session()->flash("msg_s","تم الانشاء بنجاح");

         //reset the data
         $this->reset();

     }



     public function update(){//////update category //////

         //validate of data
         $this->validate([
            'name'=>'required',
            'section_id'=>'required|exists:sections,id',
        ],[
            "name.required"=>"الاسم مطلوب",
            "section_id.required"=>"القسم مطلوب",
            "section_id.exists"=>"القسم غير موجود",
        ]);


        $category = $this->category;
        $nameCount = Category::where("name",$this->name)->count();

        //the name is existe
        if($nameCount > 0 and $this->name != $category->name){

            return session()->flash('error','هذا الاسم محجوز');
        }else{
            //insert data
            $category->update([
                'name'=>$this->name,
                'section_id'=>$this->section_id,
            ]);

            //save the change
            $this->category->save();

            //success message
            session()->flash("msg_s","تم التحديث بنجاح");

            //reset the data
            $this->reset();
        }
     }






     public function delete(){

         //check the encrypt value
         if(Hash::check($this->category_id,$this->category_id_enc)){

             //get the data
             $category = $this->category;

             //delete category
             $category->delete();

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
