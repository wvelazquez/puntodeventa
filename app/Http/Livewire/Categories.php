<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Flight;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Category::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Category::orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.category.categories', ['categories' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id)
    {
        
        $record = Category::find($id, ['id', 'name', 'image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show Modal');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:categories|min:3'

        ];
        $message = [
            'name.required' => 'Nombre de la categoria es requerido',
            'name.unique' => 'Ya existe el nombre de la categoria',
            'name.min' => 'Minimo debe contener 3 catacteres'
        ];

        $this->validate($rules, $message);

        $category = Category::create([
            'name' => $this->name
        ]);

        $customFileName;
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->StoreAs('public/categories', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        $this->resetUI();
        $this->emit('category-added', 'categoria registrada');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}"

        ];
        $message = [
            'name.required' => 'Nombre de la categoria es requerido',
            'name.min' => 'Minimo debe contener 3 catacteres',
            'name.unique' => 'Ya existe el nombre de la categoria'
        ];

        $this->validate($rules, $message);

        $category = Category::find($this->selected_id);
        $category->update(['name' => $this->name]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);
            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();
            if ($imageName != null) {
                if (file_exists('public/categories' . $imageName)) {
                    unlink('storage/categories/' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('category-updated', 'categoria actualizada');
    }

    public function resetUI()
    {

        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }


    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy($id){
        $category = Category::find($id);
        $imageName = $category->image; //imagen temporal para eliminarla
        $category->delete();

        if($imageName != null){
            unlink('storage/categories/'. $imageName);
        }

        $this->resetUI();
        $this->emit('category-deleted', 'Categoria Eliminada');


    }
}
