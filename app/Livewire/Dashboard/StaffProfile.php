<?php

namespace App\Livewire\Dashboard;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffProfile extends Component
{

    use WithFileUploads;

    #[Layout("layouts.dashboard")]
    //Fields
    public $staff;
    public $name;
    public $email;
    public $password;
    public $image;
    public $old_image;
    public $gender;

    public $passwordNew;
    public $c_passwordNew;

    public $show = "profile";

    public function render()
    {
        $roles = Role::all();
        return view('livewire.dashboard.staff-profile',compact("roles"));
    }




    public function showChange($name){/////////show page section////////

        if($name === "update"){

           $this->staff = User::find(auth()->id());

           if($name === "update"){
               //set data
               $this->name = $this->staff->name;
               $this->email = $this->staff->email;
               $this->gender = $this->staff->gender;
               $this->old_image = $this->staff->picture;
           }

           $this->show = $name;
        }elseif($name === "password"){
            $this->show = $name;
        }
        else{

           $this->show = "profile";
        }

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
                if(Storage::exists("public/UseImager",$this->old_image)){
                    Storage::delete("public/UseImager/".$this->old_image);
                }
                //settings of picture
                $image_name = $this->fileSettings($this->image);
            }else{//not change the picture
                $image_name = "";
            }

            // Update User
            $staff->name= $this->name;
            $staff->gender= $this->gender;
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
        $staff->gender= $this->gender;
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



public function changePassword()
{

    //Validate
    $this->passwordValidate();

    if($this->passwordNew != $this->c_passwordNew){

        return redirect()->back()->with("msg_e","الرجاء تطابق رمز السري الجديد");
    }else{

        $userData = User::find(auth()->id()); // data of this user
        //check password
        if(!Hash::check($this->passwordOld, $userData->password)){//the password is not correct

            return redirect()->back()->with("msg_e"," رمز السري القديم غير صحيح");
         }else{//the password is correct

            $userData->password =  Hash::make($this->passwordNew);
            $userData->update();
            return redirect()->route("profile")->with("msg_s","  تم التعديل  بنجاح ");
         }

    }
}



   public function cancel(){////////reset the data///////

    $this->reset();
}



public function staffValidateForUpdate(){//////////vaildations for Update/////////

    $this->validate([
        'name'=> 'required|max:50|min:6',
        'email'=>'required|email',
        'gender'=>'required',
        'image'=>'nullable|image',
    ],[
        "name.required" => "الاسم مطلوب",
        "name.max" =>"يجب ان يحتوي الاسم على الاكثر 50 حرف",
        "name.min" =>"يجب ان يحتوي الاسم على الاقل 6 حرف",
        "email.required" => "الايميل مطلوب",
        "email.email" =>"يجب ان يكون ايميل صحيح",
        "email.unique" =>"الايميل محجوز",
        "gender.required" => "الجنس مطلوب",
        "image.image" => "يجب ان تكون صورة",
    ]);
}



public function passwordValidate(){//////////vaildations for password/////////

    $this->validate([
        'password'=> 'required|min:6|max:16',
        'passwordNew'=>'required|min:6|max:16',
        'c_passwordNew'=>'required|min:6|max:16',
    ],[
        "password.required" => " الرمز السري القديم مطلوب",
        "password.max" =>"يجب ان يحتوي الرمز على الاكثر 16 حرف",
        "password.min" =>"يجب ان يحتوي الرمو على الاقل 6 حرف",
        "passwordNew.required" => "الرمز السري الجديد مطلوب",
        "passwordNew.max" =>"يجب ان يحتوي الرمز على الاكثر 16 حرف",
        "passwordNew.min" =>"يجب ان يحتوي الرمو على الاقل 6 حرف",
        "c_passwordNew.required" => "الرمز السري القديم مطلوب",
    ]);
}

}
