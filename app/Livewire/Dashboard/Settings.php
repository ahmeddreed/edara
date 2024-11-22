<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\AdsImage;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Settings as setting;
use Illuminate\Support\Facades\Storage;

class Settings extends Component
{

    use WithFileUploads;

    #[Layout("layouts.dashboard")]
    //Fields
    public $settings;
    public $settings_id;
    public $title;
    public $des;
    public $copy_right;
    public $new_img;
    public $old_img;
    public $phone1;
    public $phone2;

    //for Ads
    public $ads;
    public $ads_id;
    public $title_ads;
    public $des_ads;
    public $image_ads;


    public function  __construct() {
        //Middleware in another way
        if(auth()->user()->role_id !=1){

            $this->redirect("/Dashboard");
        }

        //data of settings from database
        $settings = Setting::findOrFail(1);

        //fields
        $this -> settings = $settings;
        $this -> settings_id = $settings->id;
        $this -> title = $settings->title;
        $this -> des = $settings->des;
        $this -> old_img = $settings->img;
        $this -> copy_right = $settings->copy_right;
        $this -> phone1 = $settings->phone1;
        $this -> phone2 = $settings->phone2;
        $this -> ads = $settings->ads()->get();

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
        $setting->phone1 = $this->phone1;
        $setting->phone2 = $this->phone2;
        //change the image
        if($this->new_img){
            $setting->img = $imgName;
        }

        $setting->update();


        session()->flash("msg_s","تم التحديث بنجاح");
    }


    public function addAds(){
        // Validation
        $this->validate([
           "title_ads" => "required",
           "des_ads"=> "required|max:100",
           "image_ads" => "required|image",
           ],[
            "title_ads.required" => "العنوان مطلوب",
            "des_ads.required" => "الوصف مطلوب",
            "des_ads.max" => "يجب ان يكون الوصف اقل من 100 حرف",
            "image_ads.required" => "الصورة مطلوب",
            "image_ads.image" => "يجب ان تكون صورة",
        ]);


        $img_ads = $this->fileSettings($this->image_ads);

        //create Ads
        $createAds = AdsImage::create([
            "title" => $this->title_ads,
            "description" => $this->des_ads,
            "image" => $img_ads,
            "settings_id" => $this->settings_id,
        ]);

        $this -> ads =  $this -> settings->ads()->get();
        session()->flash("ads_msg_s","تم الاضافة بنجاح");
        $this->reset( "title_ads","des_ads","image_ads");
    }


    public function adsDelete($id){

        $deleteAds = AdsImage::find($id);
        if($deleteAds){

            $deleteAds->delete();
            session()->flash("ads_msg_s","تم الحذف بنجاح");
            $this->reset( "title_ads","des_ads","image_ads");
            $this -> ads =  $this -> settings->ads()->get();
        }else{

            session()->flash("ads_msg_e","لا يوجد بيانات");
        }


    }

    public function fileSettings($file){////////file settings///////
        $ext = $file->extension();
        $image_name = time().".".$ext;
        $file->storeAs("public/SettingsImage/", $image_name);

        return $image_name;
    }
}
