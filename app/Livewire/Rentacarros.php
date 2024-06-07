<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Rentacarro;

class Rentacarros extends Component
{
    use WithFileUploads;
    use WithPagination;
    use LivewireAlert;

    public $currentImage, $searchengine, $pageTitle, $componentName;
    public $image;
    public $isEditMode = false;
    public $selected_id;
    public $name;
    public $barcode;
    public $price;

    protected $rules = [
        'name' => 'required|string|max:255|min:3|unique:rentacarros,name',
        'barcode' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048'
    ];

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Renta de Maquinaria';
    }

    public function render()
    {
        $rentacarros = $this->searchengine
            ? Rentacarro::where('name', 'like', '%' . $this->searchengine . '%')->paginate(10)
            : Rentacarro::paginate(10);

        return view('livewire.rentacarros.rentacarros', compact('rentacarros'));
    }

    public function create()
    {
        $this->isEditMode = false;
        $this->resetUI();
    }
    public function Edit($id)
    {
        $record = Rentacarro::find($id, ['id', 'name','barcode','price', 'image']);
        $this->name = $record->name;
        $this->barcode = $record->barcode;
        $this->price = $record->price;
        $this->selected_id = $record->id;
        $this->currentImage = $record->image;  // Imagen actual, no la sobrescribe con la nueva imagen.
        $this->dispatch('show-modal', 'Show Modal!');
    }
    public function Store()
    {

        // Validar si la imagen no es obligatoria o hacer validaciones personalizadas
        $this->validate([
            'name' => 'required|string|max:255|min:3', // Solo como ejemplo, ajusta según tus necesidades
            'barcode' => 'required|string|max:255|min:3',
            'price' => 'required|string|max:255|min:3',
            'image' => 'nullable|image|max:2048' // Haciendo la imagen opcional
        ]);

        // Verificar si la imagen está presente
        $imagePath = $this->image
            ? $this->image->store('rentacarros')
            : 'null';  // puedes ajustar esto según tus necesidades

        Rentacarro::create([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'price' => $this->price,
            'image' => $imagePath
        ]);

        $this->reset('name','barcode','price', 'image');
        $this->dispatch('rentamaquinaria-added', 'Maquinaria Registrado!');
        $this->alert('success', 'rentamaquinaria creado!');
    }

    public function Update()
    {
        $this->validate();

        if ($this->selected_id) {
            $rentacarro = Rentacarro::find($this->selected_id);

            $data = [
                'name' => $this->name,
                'barcode' => $this->barcode,
                'price' => $this->price,
            ];

            if ($this->image) {
                $data['image'] = $this->image->store('rentacarros');
            }

            $rentacarro->update($data);

            $this->resetUI();
            $this->dispatch('rentacarros-updated', 'Maquinaria Actualizado!');
            $this->alert('success', 'Maquinaria Actualizado!');
        }
    }

    public function Delete($id)  // Asegúrate de que el ID se pasa a esta función
    {
        $this->selected_id = $id;  // Almacena el ID para usarlo en la confirmación
        $this->alert('warning', '¿Estás seguro de que quieres eliminar?', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,  // Cambiado a false para que la alerta no desaparezca automáticamente
            'showConfirmButton' => true,
            'onConfirmed' => 'confirmedDeletion',  // Agregado un manejador para la confirmación
            'showCancelButton' => true,
            'onDismissed' => '',
            'showDenyButton' => false,
            'onDenied' => '',
            'timerProgressBar' => false,
            'width' => '400',
        ]);
    }

    public function confirmedDeletion()
    {
        logger('confirmedDeletion called, ID: ' . $this->selected_id);

        $rentacarro = Rentacarro::find($this->selected_id);
        if ($rentacarro) {
            if ($rentacarro->image) {
                Storage::delete('public/rentacarros/' . $rentacarro->image);
            }
            $rentacarro->delete();
            $this->alert('success', 'Maquinaria Eliminada Exitosamente ' . $rentacarro->name);
            $this->dispatchBrowserEvent('rentacarro-deleted', ['message' => 'Maquinaria eliminado']);
        } else {
            $this->alert('error', 'El servicio de renta no se pudo encontrar.');
        }

        $this->resetUI();
    }

    protected $listeners = [
        'confirmedDeletion'
    ];

    public function resetUI()
    {
        $this->name = '';
        $this->barcode = '';
        $this->price = '';
        $this->image = null;
        $this->searchengine = '';
        $this->selected_id = 0;
    }
}