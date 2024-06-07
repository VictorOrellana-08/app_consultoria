<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Factura;
use App\Models\Facturacion;
use Livewire\WithPagination;

class Facturaciones extends Component
{
    use WithPagination;

    public $razon_social, $nit, $ncr, $actividad_economica, $nombre_comercial, $direccion, $telefono, $correo, $observaciones;

    protected $rules = [
        'razon_social' => 'required|string|max:255',
        'nit' => 'required|string|max:255',
        'ncr' => 'required|string|max:255',
        'actividad_economica' => 'required|string|max:255',
        'nombre_comercial' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'telefono' => 'required|string|max:255',
        'correo' => 'required|email|max:255',
        'observaciones' => 'nullable|string',
    ];

    public function submit()
    {
        $this->validate();

        Facturacion::create([
            'razon_social' => $this->razon_social,
            'nit' => $this->nit,
            'ncr' => $this->ncr,
            'actividad_economica' => $this->actividad_economica,
            'nombre_comercial' => $this->nombre_comercial,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'observaciones' => $this->observaciones,
        ]);

        session()->flash('message', 'Factura creada con éxito.');
    }

    public function render()
    {
        $facturas = Facturacion::paginate(10);
        return view('livewire.facturaciones.facturaciones', [
            'facturas' => $facturas,
            'componentName' => 'facturacines',
            'pageTitle' => 'Crear Facturas',
        ]);
    }
}
