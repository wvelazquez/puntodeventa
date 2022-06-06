<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Coins extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $type, $value,$componentName, $pageTitle, $selected_id, $image, $search;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Denominaciones';
        $this->selected_id = 0;
        $this->type='Elegir';
    }
    
    
    public function render()
    {
        if (strlen($this->search) > 0)
            $data = Denomination::where('type', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        else
            $data = Denomination::orderBy('id', 'desc')->paginate($this->pagination);

        return view('livewire.denominations.component', ['data' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }


    public function Edit($id)
    {
        
        $record = Denomination::find($id, ['id','type', 'value', 'image']);
        $this->type = $record->type;
        $this->selected_id = $record->id;
        $this->value = $record->value;
        $this->image = null;

        $this->emit('modal-show', 'show Modal');
    }

    public function Store()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => 'required|unique:denominations'

        ];
        $message = [
            'type.required' => 'El tipo es requerido',
            'type.not_in' => 'Elige un valor dististo de elegir',
            'value.required' => 'El valor es requerido',
            'value.unique' => 'Ya existe el valor'
        ];

        $this->validate($rules, $message);

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);

        $customFileName;
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->StoreAs('public/denominations', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        $this->resetUI();
        $this->emit('item-added', 'Denominacion registrada');
    }

    public function Update()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => "required|unique:denominations,value,{$this->selected_id}"

        ];
        $message = [
            'type.required' => 'El tipo es requerido',
            'type.not_in' => 'Elige un valor correcto',
            'value.required' => 'El valor es requerido',
            'value.unique' => 'Ya existe el valor'

        ];

        $this->validate($rules, $message);

        $denomination = Denomination::find($this->selected_id);
        $denomination->update([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $imageName = $denomination->image;

            $denomination->image = $customFileName;
            $denomination->save();
            if ($imageName != null) {
                if (file_exists('public/denominations' . $imageName)) {
                    unlink('storage/denominations/' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated', 'Denominacion actualizada');
    }

    public function resetUI()
    {

        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }


    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy($id){
        $denomination = Denomination::find($id);
        $imageName = $denomination->image; //imagen temporal para eliminarla
        $denomination->delete();

        if($imageName != null){
            unlink('storage/denominations/'. $imageName);
        }

        $this->resetUI();
        $this->emit('item-deleted', 'Denominacion Eliminada');


    }


}
