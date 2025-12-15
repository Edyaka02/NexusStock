<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// Importamos tus Modelos y Controladores nuevos
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\InventoryMovement;
use App\Models\AuditLog;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí conectamos las URLs con tu Backend (ProductController).
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

// Rutas de Autenticación (Básicas, usan las vistas que ya tienen)
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', function () { return redirect('/dashboard'); });
Route::post('/logout', function () { return redirect('/login'); })->name('logout');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/register', function () { return redirect('/dashboard'); });

// =========================================================================
// DASHBOARD (Ahora con DATOS REALES de SQL Server)
// =========================================================================
Route::get('/dashboard', function () {
    // 1. Contamos productos reales
    $totalProducts = Product::count();
    
    // 2. Buscamos productos con stock bajo (menor o igual al min_stock o 5)
    $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')->get();
    $lowStockCount = $lowStockProducts->count();
    
    // 3. Movimientos de hoy (SQL Server usa GETDATE, Laravel lo maneja)
    $movementsToday = InventoryMovement::whereDate('created_at', today())->count();
    
    // 4. Valor total del inventario (Precio * Stock)
    // Se hace en PHP para evitar complejidad de query si SQL Server varía versión
    $totalValue = Product::all()->sum(function($prod) {
        return $prod->price * $prod->stock;
    });

    return view('dashboard.index', compact('totalProducts', 'lowStockCount', 'movementsToday', 'totalValue', 'lowStockProducts'));
})->name('dashboard.index');


// =========================================================================
// RUTAS DE PRODUCTOS (Conectadas a tu ProductController)
// =========================================================================

// Listar productos
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Ver formulario de crear (Si Valery lo hizo, si no, da igual tenerlo)
Route::view('/products/create', 'products.create')->name('products.create');

// Guardar nuevo producto
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Ver detalle de producto
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Editar producto (Placeholder: muestra la vista, pero el update redirige)
Route::get('/products/{id}/edit', function ($id) {
    $product = Product::findOrFail($id);
    return view('products.edit', compact('product'));
})->name('products.edit');

Route::put('/products/{id}', function ($id) {
    // Si tienes tiempo, puedes agregar el método 'update' en tu controlador
    return redirect()->route('products.index'); 
})->name('products.update');

Route::delete('/products/{id}', function ($id) {
    // Si tienes tiempo, agrega 'destroy' en tu controlador
    return redirect()->route('products.index');
})->name('products.destroy');


// =========================================================================
// RUTAS DE INVENTARIO Y TRANSACCIONES
// =========================================================================

// Esta es la ruta CRÍTICA para la evaluación: COMPRA y VENTA
Route::post('/transaction', [ProductController::class, 'transaction'])->name('inventory.transaction');

// Pantalla para hacer movimientos manuales
Route::get('/inventory/new-movement', function () {
    $products = Product::all(); // Pasamos productos reales para el select
    return view('inventory.new-movement', compact('products'));
})->name('inventory.new-movement');

// Historial de movimientos
Route::get('/inventory/movements', function () {
    $movements = InventoryMovement::with(['product', 'user'])->orderBy('created_at', 'desc')->get();
    return view('inventory.movements', compact('movements'));
})->name('inventory.movements');


// =========================================================================
// OTRAS RUTAS (Auditoría y Usuarios)
// =========================================================================
Route::get('/audit/logs', function () {
    $logs = AuditLog::orderBy('created_at', 'desc')->get();
    return view('audit.logs', compact('logs'));
})->name('audit.logs');

Route::get('/users', function () {
    $users = User::all();
    return view('users.index', compact('users'));
})->name('users.index');

// Rutas placeholder para crear usuarios (para que no den error 404)
Route::view('/users/create', 'users.create')->name('users.create');
Route::post('/users', function() { return redirect('/users'); })->name('users.store');
Route::get('/users/{id}/edit', function() { return redirect('/users'); })->name('users.edit');
Route::put('/users/{id}', function() { return redirect('/users'); })->name('users.update');
Route::delete('/users/{id}', function() { return redirect('/users'); })->name('users.destroy');
