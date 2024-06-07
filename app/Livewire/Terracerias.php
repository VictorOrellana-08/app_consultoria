<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Terraceria;

class Terracerias extends Component
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
        'name' => 'required|string|max:255|min:3|unique:terracerias,name',
        'barcode' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048'
    ];

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Terracerias';
    }

    public function render()
    {
        $terracerias = $this->searchengine
            ? Terraceria::where('name', 'like', '%' . $this->searchengine . '%')->paginate(10)
            : Terraceria::paginate(10);

        return view('livewire.terracerias.terracerias', compact('terracerias'));
    }

    public function create()
    {
        $this->isEditMode = false;
        $this->resetUI();
    }
    public function Edit($id)
    {
        $record = Terraceria::find($id, ['id', 'name','barcode','price', 'image']);
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
            ? $this->image->store('terracerias')
            : 'null';  // puedes ajustar esto según tus necesidades

        Terraceria::create([
            'name' => $this->name,
            'barcode' => $this->barcode,
            'price' => $this->price,
            'image' => $imagePath
        ]);

        $this->reset('name','barcode','price', 'image');
        $this->dispatch('terraceria-added', 'Terraceria Registrada!');
        $this->alert('success', 'terraceria creada!');
    }

    public function Update()
    {
        $this->validate();

        if ($this->selected_id) {
            $terracerias = Terraceria::find($this->selected_id);

            $data = [
                'name' => $this->name,
                'barcode' => $this->barcode,
                'price' => $this->price,
            ];

            if ($this->image) {
                $data['image'] = $this->image->store('terracerias');
            }

            $terracerias->update($data);

            $this->resetUI();
            $this->dispatch('terracerias-updated', 'terracerias Actualizado!');
            $this->alert('success', 'terracerias Actualizado!');
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

        $terraceria = Terraceria::find($this->selected_id);
        if ($terraceria) {
            if ($terraceria->image) {
                Storage::delete('public/terracerias/' . $terraceria->image);
            }
            $terraceria->delete();
            $this->alert('success', 'terraceria Eliminado Exitosamente ' . $terraceria->name);
            $this->dispatchBrowserEvent('terraceria-deleted', ['message' => 'terraceria eliminado']);
        } else {
            $this->alert('error', 'El terraceria no se pudo encontrar.');
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