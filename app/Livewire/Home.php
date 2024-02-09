<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Material;
use App\Models\Section;
use Exception;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout("layouts.main")]

class Home extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // public $materials;
    public $section = null;

    public $section_id = null;
    public $categories = null;

    public $category_id = null;
    public $search ="";
    public $numberOfPage = 15;


    public function render()
    {

        if(!$this->section_id)
            $this->resetData();
        else
            $this->categories = Category::where("section_id",$this->section_id)->get();

        $materials = $this->showData();
        return view('livewire.home',compact("materials"));
    }




    public function resetData(){
        $this->section = Section::all();
        $this->categories = Category::all();
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
