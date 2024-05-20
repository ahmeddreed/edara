<?php

namespace App\Livewire;

use Exception;
use App\Models\Section;
use Livewire\Component;
use App\Models\Category;
use App\Models\Material;
use App\Models\Settings;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout("layouts.main")]

class Home extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // public $materials;
    public $section = null;

    public $section_id = null;

    public $category_id = null;
    public $search ="";
    public $numberOfPage = 15;


    public function mount(?int $id = null){
        $this->section_id = $id;
    }
    public function render()
    {
        $categories = null;

        if(!$this->section_id){
            $this->resetData();
            $categories = Category::all();
        }else{
            $this->section = Section::all();
            $categories = Category::where("section_id",$this->section_id)->get();
        }

        return view('livewire.home',compact("categories"));
    }


    public function changeSection($name=null){
        $this->search =$name;
    }

    public function changeRoute($id = null){
        return $this->redirect('/home/'.$id, navigate: true);
    }

    public function resetData(){
        $this->section = Section::all();
        $this->section_id = null;
        $this->category_id =null;
    }




    public function showData(){//////show all data /////////

        $materials =  Material::paginate($this->numberOfPage);

        if($this->search == ""){// not searching

            if($this->section_id == null){////////

                // $materials = Material::latest()->paginate($this->numberOfPage);
                $materials = Material::paginate($this->numberOfPage);
            }else{

                if($this->category_id != null)//select the category
                    $materials = Material::where("category_id",$this->category_id)->paginate($this->numberOfPage);
                else{//not select the category and set the defualt data
                    $categoriy = Category::where("section_id",$this->section_id)->first();
                    $materials = Material::where("category_id",$categoriy->id)->paginate($this->numberOfPage);
                }

            }
        }else{//searching

            if($this->section_id == null){////////

                $materials = Material::where("title","like",'%'.$this->search.'%')
                                            ->OrWhere("discription","like",'%'.$this->search.'%')
                                            ->paginate($this->numberOfPage);
            }else{//////////

                if($this->category_id != null){//select the category
                    $materials = Material::where("category_id",$this->category_id)
                                        ->where("title","like",'%'.$this->search.'%')
                                        ->OrWhere("discription","like",'%'.$this->search.'%')
                                        ->paginate($this->numberOfPage);

                }else{//not select the category and set the defualt data
                    $categoriy = Category::where("section_id",$this->section_id)->first();
                    $materials = Material::where("category_id",$categoriy->id)
                                        ->where("title","like",'%'.$this->search.'%')
                                        ->OrWhere("discription","like",'%'.$this->search.'%')
                                        ->paginate($this->numberOfPage);
                }
            }
        }

        return $materials;
    }



}
