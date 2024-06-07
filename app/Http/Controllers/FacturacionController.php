<?php

// app/Http/Controllers/FacturacionController.php
namespace App\Http\Controllers;

use App\Models\Facturacion;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use PDF;

class FacturacionController extends Controller
{
    public function generatePDF()
    {
        $facturaciones = Facturacion::all();
        $sales = Sale::all();

        foreach ($sales as $sale) {
            $sale->products = Product::join('sale_product', 'products.id', '=', 'sale_product.product_id')
                                    ->where('sale_product.sale_id', $sale->id)
                                    ->get(['products.*']);
        }

        $pdf = PDF::loadView('factura.facturasReport', compact('facturaciones', 'sales'));
        return $pdf->download('facturasReport.pdf');
    }
    
    public function generateFacturaPDF()
    {
        $facturaciones = Facturacion::all();
        $sales = Sale::all();

        foreach ($sales as $sale) {
            $sale->products = Product::join('sale_product', 'products.id', '=', 'sale_product.product_id')
                                    ->where('sale_product.sale_id', $sale->id)
                                    ->get(['products.*']);
        }

        $pdf = PDF::loadView('facturaelectronica.factura', compact('facturaciones', 'sales'));
        return $pdf->download('factura.pdf');
    }
}

