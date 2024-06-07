<?php

namespace App\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use App\Models\Servicio;
use App\Models\Rentacarro; // Importar el modelo Rentacarro
use App\Models\Terraceria; // Importar el modelo Terraceria
use App\Models\Sale;
use App\Models\SaleDetail;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Pos extends Component
{
    use LivewireAlert;

    public $total, $itemsQuantity, $denominations, $efectivo, $change, $componentName, $products, $servicios, $rentacarros, $terracerias, $barcode, $selected_id;

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->componentName = 'Sales';
        $this->servicios = Servicio::all(); // Obtener todos los servicios
        $this->rentacarros = Rentacarro::all(); // Obtener todos los rentacarros
        $this->terracerias = Terraceria::all(); // Obtener todas las terracerias
    }

    public function render()
    {
        $this->denominations = Denomination::all();

        return view('livewire.pos.pos', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'cart' => Cart::getContent()->sortBy('name'),
            'servicios' => $this->servicios,
            'rentacarros' => $this->rentacarros,
            'terracerias' => $this->terracerias,
        ]);
    }

    public function ACash($value)
    {
        $this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'deletes' => 'deletes',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale'
    ];

    public function ScanCode()
    {
        $barcode = $this->barcode; // Obtener el valor del código de barras del modelo de Livewire

        // Validar si el código de barras está presente
        if (empty($barcode)) {
            $this->alert('warning', 'El código de barras está vacío');
            return;
        }

        // Buscar el producto por el código de barras
        $product = Product::where('barcode', $barcode)->first();

        // Si no es un producto, intentar encontrar un servicio, rentacarro o terraceria
        if (!$product) {
            $service = Servicio::where('barcode', $barcode)->first();
            $rentacarro = Rentacarro::where('barcode', $barcode)->first();
            $terraceria = Terraceria::where('barcode', $barcode)->first();

            if ($service) {
                // Validar si el servicio ya está en el carrito
                if ($this->InCart($service->id)) {
                    $this->increaseServiceQty($service->id);
                    $this->alert('success', 'Cantidad actualizada');
                    $this->barcode = '';
                    return;
                }

                // Agregar el servicio al carrito
                Cart::add($service->id, $service->name, $service->price, 1);

                // Actualizar el total y la cantidad de ítems
                $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
                $this->itemsQuantity = Cart::getTotalQuantity();

                // Enviar una notificación de éxito
                $this->alert('success', 'Servicio agregado');
                $this->barcode = '';
                return;
            } elseif ($rentacarro) {
                // Validar si el rentacarro ya está en el carrito
                if ($this->InCart($rentacarro->id)) {
                    $this->increaseRentacarroQty($rentacarro->id);
                    $this->alert('success', 'Cantidad actualizada');
                    $this->barcode = '';
                    return;
                }

                // Agregar el rentacarro al carrito
                Cart::add($rentacarro->id, $rentacarro->name, $rentacarro->price, 1);

                // Actualizar el total y la cantidad de ítems
                $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
                $this->itemsQuantity = Cart::getTotalQuantity();

                // Enviar una notificación de éxito
                $this->alert('success', 'Rentacarro agregado');
                $this->barcode = '';
                return;
            } elseif ($terraceria) {
                // Validar si la terraceria ya está en el carrito
                if ($this->InCart($terraceria->id)) {
                    $this->increaseTerraceriaQty($terraceria->id);
                    $this->alert('success', 'Cantidad actualizada');
                    $this->barcode = '';
                    return;
                }

                // Agregar la terraceria al carrito
                Cart::add($terraceria->id, $terraceria->name, $terraceria->price, 1);

                // Actualizar el total y la cantidad de ítems
                $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
                $this->itemsQuantity = Cart::getTotalQuantity();

                // Enviar una notificación de éxito
                $this->alert('success', 'Terraceria agregada');
                $this->barcode = '';
                return;
            } else {
                // Ningún producto, servicio, rentacarro ni terraceria encontrado
                $this->alert('warning', 'El producto, servicio, rentacarro o terraceria no fue encontrado');
                return;
            }
        }

        // Validar si el producto ya está en el carrito
        if ($this->InCart($product->id)) {
            $this->increaseQty($product->id);
            $this->alert('success', 'Cantidad actualizada');
            $this->barcode = '';

            return;
        }

        // Validar si hay stock disponible
        if ($product->stock < 1) {
            $this->alert('warning', 'Stock insuficiente');
            return;
        }

        // Agregar el producto al carrito
        Cart::add($product->id, $product->name, $product->price, 1, $product->image);

        // Actualizar el total y la cantidad de ítems
        $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
        $this->itemsQuantity = Cart::getTotalQuantity();

        // Enviar una notificación de éxito
        $this->alert('success', 'Producto agregado');
        $this->barcode = '';
    }

    public function InCart($productId)
    {
        $exist = Cart::get($productId);
        if ($exist) {
            return true;
        } else {
            return false;
        }
    }

    public function increaseQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);

        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = 'Producto agregado';
        }

        // Verificación del stock
        if ($product->stock < ($cant + $exist->quantity)) {
            // Lista de íconos válidos (ajusta según tu sistema)
            $validIcons = ['info', 'warning', 'error', 'success']; // Agrega todos los íconos válidos
            $icon = 'no-stock';

            // Si el ícono no es válido, usa uno por defecto
            if (!in_array($icon, $validIcons)) {
                $icon = 'warning'; // Ícono por defecto en caso de que 'no-stock' no sea válido
            }

            $this->alert($icon, 'Stock insuficiente');
            return;
        }

        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
        $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->alert('success', $title);
    }

    public function updateQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist)
            $title = 'Cantidad actualizada';
        else
            $title = 'Producto agregado';

        if ($exist)
        {
            if ($product->stock < $cant)
            {
                $this->emit('no-stock', 'Stock insuficiente :/');
                return;
            }
        }

        $this->deletes($productId);
        if ($cant > 0)
        {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->emit('scan-ok', $title);
        }
    }

    public function deletes($productId)
    {
        Cart::remove($productId); // Utiliza el ID del producto pasado como parámetro
        $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->alert('success', 'Producto eliminado');
    }

    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);
        $newQty = ($item->quantity) - 1;
        if ($newQty > 0)
            Cart::add($item->id, $item->name, $item->price, $newQty);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->alert('success', 'Cantidad actualizada');
    }


    public function increaseServiceQty($serviceId, $cant = 1)
    {
        $title = '';
        $service = Servicio::find($serviceId);
        $exist = Cart::get($serviceId);
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = 'Servicio agregado';
        }

        Cart::add($service->id, $service->name, $service->price, $cant);
        $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->alert('success', $title);
    }

    public function increaseRentacarroQty($rentacarroId, $cant = 1)
    {
        $title = '';
        $rentacarro = Rentacarro::find($rentacarroId);
        $exist = Cart::get($rentacarroId);
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = 'Rentacarro agregado';
        }

        Cart::add($rentacarro->id, $rentacarro->name, $rentacarro->price, $cant);
        $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->alert('success', $title);
    }

    public function increaseTerraceriaQty($terraceriaId, $cant = 1)
    {
        $title = '';
        $terraceria = Terraceria::find($terraceriaId);
        $exist = Cart::get($terraceriaId);
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = 'Terraceria agregada';
        }

        Cart::add($terraceria->id, $terraceria->name, $terraceria->price, $cant);
        $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->alert('success', $title);
    }

    public function clearCart()
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->alert('success', 'Carro vacío');
    }

    public function saveSale()
    {
        if ($this->total <= 0) {
            $this->alert('warning', 'AGREGA PRODUCTOS O SERVICIOS A LA VENTA');
            return;
        }
        if ($this->efectivo <= 0) {
            $this->alert('warning', 'INGRESA EL EFECTIVO');
            return;
        }
        if ($this->total > $this->efectivo) {
            $this->alert('warning', 'EL EFECTIVO DEBE SER MAYOR O IGUAL AL TOTAL');
            return;
        }
        DB::beginTransaction();
        try {
            $totalSinIva = $this->total / 1.13; // Calcular total sin IVA
            $iva = $this->total - $totalSinIva; // Calcular el IVA

            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash'  => $this->efectivo,
                'change'  => $this->change,
                'iva' => $iva, // Guardar el valor del IVA
                'user_id' => Auth::user()->id
            ]);

            if ($sale) {
                $items = Cart::getContent();
                foreach ($items as $item) {
                    if ($item->price) {
                        SaleDetail::create([
                            'price' => $item->price,
                            'quantity' => $item->quantity,
                            'product_id' => $item->id,
                            'sale_id' => $sale->id,
                        ]);

                        // Actualizar STOCK si es un producto
                        $product = Product::find($item->id);
                        $product->stock = $product->stock - $item->quantity;
                        $product->save();
                    } else {
                        SaleDetail::create([
                            'price' => $item->price,
                            'quantity' => $item->quantity,
                            'service_id' => $item->id,
                            'sale_id' => $sale->id,
                        ]);
                    }
                }
            }

            DB::commit();

            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;
            $this->total = Cart::getTotal() * 1.13; // Incluir el 13%
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->alert('success', 'Venta registrada con éxito');
            // $this->dispatch('print-ticket', $sale->id); // Esto es opcional, depende de cómo quieras manejar la impresión del ticket
        } catch (Exception $e) {
            DB::rollBack();
            $this->alert('error', 'Ocurrió un error al guardar la venta: ' . $e->getMessage());
        }
    }

    public function printTicket($sale)
    {
        return Redirect::to("print://$sale->id");
    }
}
