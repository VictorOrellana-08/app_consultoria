<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Servicio;

class Servicios extends Component
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
        'name' => 'required|string|max:255|min:3|unique:servicios,name',
        'barcode' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048'
    ];

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Servicios';
    }

    public function render()
    {
        $servicios = $this->searchengine
            ? Servicio::where('name', 'like', '%' . $this->searchengine . '%')->paginate(10)
            : Servicio::paginate(10);

        return view('livewire.servicios.servicios', compact('servicios'));
    }

    public function create()
    {
        $this->isEditMode = false;
        $this->resetUI();
    }
    public function Edit($id)
    {
        $record = Servicio::find($id, ['id', 'name','barcode','price', 'image']);
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
            ? $this->image->store('servicios')
            : 'null';  // puedes ajustar esto según tus necesidades

        Servicio::create([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'price' => $this->price,
            'image' => $imagePath
        ]);

        $this->reset('name','barcode','price', 'image');
        $this->dispatch('servicio-added', 'Servicio Registrado!');
        $this->alert('success', 'Servicio creado!');
    }

    public function Update()
    {
        $this->validate();

        if ($this->selected_id) {
            $servicio = Servicio::find($this->selected_id);

            $data = [
                'name' => $this->name,
                'barcode' => $this->barcode,
                'price' => $this->price,
            ];

            if ($this->image) {
                $data['image'] = $this->image->store('servicios');
            }

            $servicio->update($data);

            $this->resetUI();
            $this->dispatch('servicio-updated', 'Servicio Actualizado!');
            $this->alert('success', 'Servicio Actualizado!');
        }
    }

    public function Delete($id)  // Asegúrate de que el ID se pasa a esta función
    {
        $this->selected_id = $id;  // Almacena el ID para usarlo en la confirmación
        $this->alert('warning', 'Are you sure you want to delete?', [
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

        $servicio = Servicio::find($this->selected_id);
        if ($servicio) {
            if ($servicio->image) {
                Storage::delete('public/servicios/' . $servicio->image);
            }
            $servicio->delete();
            $this->alert('success', 'Servicio Eliminado Exitosamente ' . $servicio->name);
            $this->dispatchBrowserEvent('servicio-deleted', ['message' => 'Servicio eliminado']);
        } else {
            $this->alert('error', 'El servicio no se pudo encontrar.');
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