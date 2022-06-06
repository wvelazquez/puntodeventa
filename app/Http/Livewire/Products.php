<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Flight;

class Products extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $name, $barcode, $price, $stock, $alerts, $cost, $category_id, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->category_id = 'Elegir';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
           $products = Product::join('categories as c', 'c.id', 'products.category_id')
                        ->select('products.*', 'c.name as category')
                        ->where('products.name', 'like', '%' . $this->search . '%')
                        ->orWhere('products.barcode', 'like', '%' . $this->search . '%')
                        ->orWhere('c.name', 'like', '%' . $this->search . '%')
                        ->orderBy('products.name', 'asc')
                        ->paginate($this->pagination);
        else
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                        ->select('products.*', 'c.name as category')
                        ->orderBy('products.name', 'asc')
                        ->paginate($this->pagination);

           
        return view('livewire.products.component', [
            'data' => $products, 
            'categories' => Category::orderBy('name', 'asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');

    }


    public function Store()
    {
        $rules = [
            'name' => 'required|unique:products|min:3',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'category_id' => 'required|not_in:Elegir'


        ];
        $messages = [
            'name.required' => 'Nombre del producto es requerido',
            'name.unique' => 'Ya existe el producto',
            'name.min' => 'Minimo debe contener 3 catacteres',
            'cost.required' => 'El costo es un valor requerido',
            'category_id.not_in' => 'Elige un nombre de la categoria diferente a la opcion elegir',
            'price.required' => 'El precio es un valor requerido',
            'stock.required' => 'El stock es requerido',
            'alerts.required' => 'Ingresa el valor minimo de existencias',

        ];
        $this->validate($rules, $messages);

        $product = Product::create([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->category_id,
        ]);

        $customFileName;
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->StoreAs('public/products', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }

        $this->resetUI();
        $this->emit('product-added', 'Producto Registrado');
    }

    public function Edit($id)
    {
        
        $record = Product::find($id, ['id', 'name', 'cost', 'price', 'barcode', 'stock', 'alerts', 'category_id']);
        $this->selected_id = $record->id;
        $this->name = $record->name;
        $this->cost = $record->cost;
        $this->price = $record->price;
        $this->barcode = $record->barcode;
        $this->stock = $record->stock;
        $this->alerts = $record->alerts;
        $this->category_id = $record->category_id;        
        $this->image = null;

        $this->emit('modal-show', 'show Modal');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'category_id' => 'required|not_in:Elegir'


        ];
        $messages = [
            'name.required' => 'Nombre del producto es requerido',
            'name.unique' => 'Ya existe el producto',
            'name.min' => 'Minimo debe contener 3 catacteres',
            'cost.required' => 'El costo es un valor requerido',
            'category_id.not_in' => 'Elige un nombre de la categoria diferente a la opcion elegir',
            'price.required' => 'El precio es un valor requerido',
            'stock.required' => 'El stock es requerido',
            'alerts.required' => 'Ingresa el valor minimo de existencias',

        ];
        $this->validate($rules, $messages);


        $product = Product::find($this->selected_id);
        $product->update([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->category_id,
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $imageName = $product->image;//imagen temporal

            $product->image = $customFileName;
            $product->save();
            if ($imageName != null) {
                if (file_exists('public/products/' . $imageName)) {
                    unlink('storage/products/' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('product-updated', 'Producto Actualizado');
    }


    public function resetUI()
    {
        $this->name = '';
        $this->cost = '';
        $this->price = '';
        $this->barcode = '';
        $this->alerts = '';
        $this->search = '';
        $this->category_id = 'Elegir';
        $this->image = null;
        $this->selected_id = 0;

    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy($id){
        $product = Product::find($id);
        $imageName = $product->image; //imagen temporal para eliminarla
        $product->delete();

        if($imageName != null){
            unlink('storage/products/'. $imageName);
        }

        $this->resetUI();
        $this->emit('Product-deleted', 'Producto Eliminada');


    }

}
