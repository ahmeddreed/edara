<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Settings as setting;
use Illuminate\Support\Facades\Storage;

class Settings extends Component
{

    use WithFileUploads;

    #[Layout("layouts.dashboard")]
    //Fields
    public $title;
    public $des;
    public $copy_right;
    public $new_img;
    public $old_img;

    public function  __construct() {
        //Middleware in another way
        if(auth()->user()->role_id !=1){

            $this->redirect("/Dashboard");
        }

        //data of settings from database
        $settings = Setting::findOrFail(1);

        //fields
        $this -> title = $settings->title;
        $this -> des = $settings->des;
        $this -> old_img = $settings->img;
        $this -> copy_right = $settings->copy_right;
    }

    public function render()
    {

        return view('livewire.dashboard.settings');
    }

    public function update(){
        $imgName =null;
        // Validation
        $this->validate([
           "title" => "required",
           "des"=> "required|min:20",
           "copy_right" => "required",
           ],[
            "title.required" => "العنوان مطلوب",
            "des.required" => "الوصف مطلوب",
            "des.min" => "يجب ان يكون الوصف اكثر من 20 حرف",
            "copy_right.required" => "العلامة التجارية مطلوب",
        ]);

        //change the image
        if($this->new_img){
            if($this->old_img){
                // Delete the Old Picture
                if(Storage::exists("public/SettingsImage",$this->old_img)){
                    Storage::delete("public/SettingsImage/".$this->old_img);
                }
            }
            $this->fileSettings($this->img);
        }


        //update data in database

        $setting = Setting::find(1);

        $setting->title = $this->title;
        $setting->des = $this->des;
        $setting->copy_right = $this->copy_right;

        //change the image
        if($this->new_img){
            $setting->img = $imgName;
        }

        $setting->update();


        session()->flash("msg_s","تم التحديث بنجاح");
    }



    public function fileSettings($file){////////file settings///////
        $ext = $file->extension();
        $image_name = time().".".$ext;
        $file->storeAs("public/SettingsImage/", $image_name);

        return $image_name;
    }
}
