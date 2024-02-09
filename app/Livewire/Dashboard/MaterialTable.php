<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Category;
use App\Models\Material;
use DateTime;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MaterialTable extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Layout("layouts.dashboard")]



    public $material_id;
    public $material_id_enc = "";
    public $material;


    //Fields
    public $title;

    public $price;
    public $discription;
    public $image;
    public $old_image;
    public $note;
    public $user_id;
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

        $materials = $this->showData();
        $categories = Category::all();
        return view('livewire.dashboard.material-table',compact("categories","materials"));
    }


    public function showData(){///////// show defualt data ////////

        $data = Material::latest()->paginate(10);
        if($this->search){//searching

           $data = Material::where('title','like','%'.$this->search.'%')->paginate(10);
        }

        return $data;
     }



    public function showChange($name, $id = null,$enc =null){/////////show page section////////

         if($name === "update" or $name === "delete" and $id != null and $enc != null){

            $this->material_id = $id;
            $this->material = Material::find($id);

            if($name === "update"){
                //set data
                $this->title = $this->material->title;
                $this->price = $this->material->price;
                $this->discription = $this->material->discription;
                $this->note = $this->material->salary;
                $this->old_image = $this->material->image;
                $this->category_id = $this->material->category_id;
            }

            $this->show = $name;
            $this->material_id_enc = $enc;
         }elseif($name == "table" || $name == "add"){

             $this->show = $name;
         }else{

            $this->show = "table";
         }

    }


    public function create(){//////create material//////

        // dd($this->image);

        //validate data
        $this->materialValidate();

        //Image settings
        $image_name = $this->fileSettings($this->image);

        // dd($image_name,$this->discription,$this->category_id,$this->price,$this->title);

        // insert data
        Material::insert([
            'title'=> $this->title,
            'price'=> $this->price,
            'discription'=> $this->discription,
            'note'=> $this->note,
            'user_id'=> auth()->id(),
            'category_id'=> $this->category_id,
            'image'=> $image_name,
            'created_at'=> date_create(),
        ]);

        // message
        session()->flash("msg_s","تم انشاء الحساب بنجاح ");

        //reset the data
        $this->reset();

    }



    public function update(){//////update material//////

        //defualt value of image
        $image_name = null;


        //validate of data
        $this->materialValidateForUpdate();

        $material = $this->material;


        //email count
        $titleCount = Material::where('title',$this->title)->count();

        //the email is
        if($titleCount > 0){
            if($material->title == $this->title){//not change the Email

                //he is have a image
                if($this->image != null){
                    // Delete the Old Picture
                    if(Storage::exists("public/MaterialImager",$this->old_image)){
                        Storage::delete("public/MaterialImager/".$this->old_image);
                    }
                    //settings of picture
                    $image_name = $this->fileSettings($this->image);
                }

                // Update Material
                // $material->uset_id= auth()->id();
                $material->category_id = $this->category_id;
                $material->price= $this->price;
                $material->discription= $this->discription;

                if($this->image != null){//change the picture
                    $material->image = $image_name;
                }

            //save the change
            $material->update();

            //success message
            session()->flash("msg_s","تم التحديث بنجاح");

            //reset the data
            $this->reset();

            }else{//the Email is exists
                session()->flash("msg_e","البريد الالكتروني محجوز");
            }
        }else{
            // Update Material
            $material->title= $this->title;
            // $material->uset_id= auth()->id();
            $material->category_id = $this->category_id;
            $material->price= $this->price;
            $material->discription= $this->discription;
            if($this->image != null){//change the picture
                $material->picture= $image_name;
            }

            //save the change
            $material->save();

            //success message
            session()->flash("msg_s","تم التحديث بنجاح");

            //reset the data
            $this->reset();

        }
    }



    public function delete(){
        //check the encrypt value
        if(Hash::check($this->material_id,$this->material_id_enc)){
            //get the data
            $material = $this->material;

            //he is have a image
            if($material->image != null){
                // Delete the Old Picture
                if(Storage::exists("public/MateriallImager",$material->old_image)){
                    Storage::delete("public/MateriallImager/".$this->old_image);
                }
            }
            //delete material
            $material->delete();

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



    public function fileSettings($file){////////file settings///////
        $ext = $file->extension();
        $image_name = time().".".$ext;
        $file->storeAs("public/MaterialImager/", $image_name);

        return $image_name;
    }


    public function materialValidate(){//////////vaildations/////////

        $this->validate([
            'title'=> 'required|max:50|min:6|unique:materials',
            'price'=>'required',
            'discription'=>'required',
            'note'=> 'nullable',
            'category_id'=>'required',
            'image'=>'required|image',
        ],[
            "title.required" => "الاسم مطلوب",
            "title.max" =>"يجب ان يحتوي الاسم على الاكثر 50 حرف",
            "title.min" =>"يجب ان يحتوي الاسم على الاقل 6 حرف",
            "title.unique" =>"الاسم محجوز",
            "price.required" => "السعر مطلوب",
            "discription.required" => " الوصف مطلوب",
            "category_id.required" => " الفئة مطلوب",
            "image.required" => "الصورة  مطلوب",
            "image.image" => "يجب ان تكون صورة",
        ]);
    }

    public function materialValidateForUpdate(){//////////vaildations for Update/////////

        $this->validate([
            'title'=> 'required|max:50|min:6',
            'price'=>'required',
            'discription'=>'required',
            'note'=> 'nullable',
            'category_id'=>'required',
            'image'=>'nullable|image',
        ],[
            "title.required" => "الاسم مطلوب",
            "title.max" =>"يجب ان يحتوي الاسم على الاكثر 50 حرف",
            "title.min" =>"يجب ان يحتوي الاسم على الاقل 6 حرف",
            "price.required" => "السعر مطلوب",
            "discription.required" => " الوصف مطلوب",
            "category_id.required" => " الفئة مطلوب",
            "image.image" => "يجب ان تكون صورة",
        ]);
    }


}
