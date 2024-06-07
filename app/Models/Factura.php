<?php

namespace App\Models;

use App\Livewire\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'razon_social',
        'nit',
        'ncr',
        'actividad_economica',
        'nombre_comercial',
        'direccion',
        'telefono',
        'correo',
        'observaciones'
    ];

    public function sales() {
        return $this->hasMany(Sale::class);
    }

    public function showReport() {
        $facturaciones = factura::with('sales.product')->get();
        return view('reporte_facturas', compact('facturaciones'));
    }
}
