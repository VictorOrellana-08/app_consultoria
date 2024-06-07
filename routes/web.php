<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\export;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Facturaciones as LivewireFacturaciones;
use App\Livewire\Assign;
use App\Livewire\Cashout;
use App\Livewire\Categories;
use App\Livewire\Coins;
use App\Livewire\EditCoin;
use Illuminate\Support\Facades\Route;
use App\Livewire\PostComponent;
use App\Livewire\ImageUpload;
use App\Livewire\Permissions;
use App\Livewire\Pos;
use App\Livewire\Products;
use App\Livewire\Reports;
use App\Livewire\Roles;
use App\Livewire\Select2;
use App\Livewire\Servicios as LivewireServicios;
use App\Livewire\Servicios;
use App\Livewire\Rentacarros;
use App\Livewire\Terracerias;
use App\Livewire\Users;
use App\livewire\Facturaciones;
use App\Models\Facturacion;

use App\Http\Controllers\FacturaController;

use App\Http\Controllers\FacturacionController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    Route::group(['middleware' => ['role:super-admin']], function () {
        Route::get('roles', Roles::class)->name('roles');;

        Route::get('permissions', Permissions::class);

        Route::get('assign', Assign::class);

        Route::get('users', Users::class);
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('categories', Categories::class);

    Route::get('products', Products::class);

    Route::get('servicios', Servicios::class);

    Route::get('rentacarros', Rentacarros::class);

    Route::get('terracerias', Terracerias::class);

    Route::get('coins', Coins::class);

    Route::get('sales', Pos::class);

    
    Route::get('facturaciones', Facturaciones::class);


    Route::get('cash-counts', Cashout::class);

    Route::get('reports', Reports::class);




    Route::get('/facturas/pdf', [FacturacionController::class, 'generatePDF'])->name('facturas.pdf');
    Route::get('/factura/pdf', [FacturacionController::class, 'generateFacturaPDF'])->name('factura.pdf');
    
    Route::get('report/pdf/{user}/{type}/{f1}/{f2}', [export::class, 'reportPDF']);
    Route::get('report/pdf/{user}/{type}', [Export::class, 'reportPDF']);

    //REPORTS Excel
    Route::get('report/excel/{user}/{type}/{f1}/{f2}', [export::class, 'reportExcel']);
    Route::get('report/excel/{user}/{type}', [Export::class, 'reportExcel']);



    Route::get('/', Pos::class);
});






//REPORTS PDF


Route::get('select2', select2::class);


Route::get('/posts', PostComponent::class)->name('posts2');

Route::get('/image-upload', ImageUpload::class)->name('posts');

Route::get('/modal', EditCoin::class)->name('editcoin');

require __DIR__ . '/auth.php';
