<?php

namespace App\Livewire\Dashboard;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffTable extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Layout("layouts.dashboard")]



    public $staff_id;
    public $staff_id_enc = "";
    public $staff;


    //Fields
    public $name;
    public $email;
    public $password;
    public $salary;
    public $image;
    public $old_image;
    public $gender;
    public $role_id;



    public $search = "";
    public $show = "table";



    public function  __construct() {

        //Middleware in another way
        if(auth()->user()->role_id !=1){

            $this->redirect("/Dashboard");
        }
    }



    public function render(){

        $staffs = $this->showData();
        $roles = Role::all();
        return view('livewire.dashboard.staff-table',compact("staffs","roles"));
    }



    public function showData(){///////// show defualt data ////////

        $data = User::latest()->paginate(10);
        if($this->search){//searching

           $data = User::where('name','like','%'.$this->search.'%')->paginate(10);
        }

        return $data;
     }



    public function showChange($name, $id = null,$enc =null){/////////show page section////////

         if($name === "update" or $name === "delete" and $id != null and $enc != null){

            $this->staff_id = $id;
            $this->staff = User::find($id);

            if($name === "update"){
                //set data
                $this->name = $this->staff->name;
                $this->email = $this->staff->email;
                $this->gender = $this->staff->gender;
                $this->salary = $this->staff->salary;
                $this->old_image = $this->staff->picture;
                $this->role_id = $this->staff->role_id;
            }

            $this->show = $name;
            $this->staff_id_enc = $enc;
         }elseif($name == "table" || $name == "add"){

             $this->show = $name;
         }else{

            $this->show = "table";
         }

    }


    public function create(){//////create staff//////

        // dd($this->image);

        //validate data
        $this->staffValidate();

        //Image settings
        $image_name = $this->fileSettings($this->image);

        // insert the data
        User::create([
            'name'=> $this->name,
            'email'=> $this->email,
            'role_id' => $this->role_id,
            'password'=> Hash::make($this->password),
            'gender'=> $this->gender,
            'salary'=> $this->salary,
            'picture'=> $image_name,
        ]);

        // message
        session()->flash("msg_s","تم انشاء الحساب بنجاح ");

        //reset the data
        $this->reset();

    }



    public function update(){//////update staff//////

        //defualt value of image
        $image_name = "";


        //validate of data
        $this->staffValidateForUpdate();

        $staff = $this->staff;
        // $staff = User::findOrFail($this->id)->first();

        //email count
        $emailCount = User::where('email',$this->email)->count();

        //the email is
        if($emailCount > 0){
            if($staff->email == $this->email){//not change the Email

                //he is have a image
                if($this->image != null){
                    // Delete the Old Picture
                    if(Storage::exists("public/UserImager",$this->old_image)){
                        Storage::delete("public/UserImager/".$this->old_image);
                    }
                    //settings of picture
                    $image_name = $this->fileSettings($this->image);
                }else{//not change the picture
                    $image_name = "";
                }

                // Update User
                $staff->name= $this->name;
                $staff->role_id = $this->role_id;
                $staff->gender= $this->gender;
                $staff->salary= $this->salary;

                if($this->image != null){//change the picture
                    $staff->picture= $image_name;
                }

            //save the change
            $staff->save();

            //success message
            session()->flash("msg_s","تم التحديث بنجاح");

            //reset the data
            $this->reset();

            }else{//the Email is exists
                session()->flash("msg_e","البريد الالكتروني محجوز");
            }
        }else{
            // Update User
            $staff->name= $this->name;
            $staff->email= $this->email;
            $staff->role_id = $this->role_id;
            $staff->gender= $this->gender;
            $staff->salary= $this->salary;
            if($this->image != null){//change the picture
                $staff->picture= $image_name;
            }

            //save the change
            $staff->save();

            //success message
            session()->flash("msg_s","تم التحديث بنجاح");

            //reset the data
            $this->reset();

        }
    }



    public function delete(){
        //check the encrypt value
        if(Hash::check($this->staff_id,$this->staff_id_enc)){
            //get the data
            $staff = $this->staff;

            //he is have a image
            if($staff->image != null){
                // Delete the Old Picture
                if(Storage::exists("public/UserImager",$this->old_image)){
                    Storage::delete("public/UserImager/".$this->old_image);
                }
            }
            //delete staff
            $staff->delete();

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
        $file->storeAs("public/UserImager/", $image_name);

        return $image_name;
    }


    public function staffValidate(){//////////vaildations/////////

        $this->validate([
            'name'=> 'required|max:50|min:6',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|max:16',
            'gender'=>'required',
            'salary'=> 'required',
            'role_id'=>'required',
            'image'=>'required|image',
        ],[
            "name.required" => "الاسم مطلوب",
            "name.max" =>"يجب ان يحتوي الاسم على الاكثر 50 حرف",
            "name.min" =>"يجب ان يحتوي الاسم على الاقل 6 حرف",
            "email.required" => "الايميل مطلوب",
            "email.email" =>"يجب ان يكون ايميل صحيح",
            "email.unique" =>"الايميل محجوز",
            "password.required" => "الرمز السري مطلوب",
            "password.max" =>"يجب ان يحتوي الرمز السري على الاكثر 16 حرف",
            "password.min" =>"يجب ان يحتوي الرمز السري على الاقل 6 حرف",
            "gender.required" => " الجنس مطلوب",
            "salary.required" => " الراتب مطلوب",
            "role_id.required" => "الصلاحية  مطلوب",
            "image.required" => "الصورة  مطلوب",
            "image.image" => "يجب ان تكون صورة",
        ]);
    }

    public function staffValidateForUpdate(){//////////vaildations for Update/////////

        $this->validate([
            'name'=> 'required|max:50|min:6',
            'email'=>'required|email',
            'gender'=>'required',
            'salary'=> 'required',
            'role_id'=>'required',
            'image'=>'nullable|image',
        ],[
            "name.required" => "الاسم مطلوب",
            "name.max" =>"يجب ان يحتوي الاسم على الاكثر 50 حرف",
            "name.min" =>"يجب ان يحتوي الاسم على الاقل 6 حرف",
            "email.required" => "الايميل مطلوب",
            "email.email" =>"يجب ان يكون ايميل صحيح",
            "email.unique" =>"الايميل محجوز",
            "gender.required" => " الجنس مطلوب",
            "salary.required" => " الراتب مطلوب",
            "role_id.required" => "الصلاحية  مطلوب",
            "image.image" => "يجب ان تكون صورة",
        ]);
    }

}
