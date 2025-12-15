<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Placeholder: redirigir a dashboard
    return redirect('/dashboard');
});

Route::post('/logout', function () {
    // Placeholder: redirigir a login
    return redirect('/login');
})->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    // Placeholder: redirigir a dashboard
    return redirect('/dashboard');
});

// Rutas protegidas (simplificadas, sin middleware auth por ahora)
Route::get('/dashboard', function () {
    // Placeholder data
    $totalProducts = 10;
    $lowStockCount = 2;
    $movementsToday = 5;
    $totalValue = 1500.00;
    $lowStockProducts = collect([]); // Placeholder
    return view('dashboard.index', compact('totalProducts', 'lowStockCount', 'movementsToday', 'totalValue', 'lowStockProducts'));
})->name('dashboard.index');


// Productos
Route::get('/products', function () {
    $products = collect([]); // Placeholder paginated
    return view('products.index', compact('products'));
})->name('products.index');

Route::get('/products/create', function () {
    return view('products.create');
})->name('products.create');

Route::post('/products', function () {
    // Placeholder: redirigir a index
    return redirect('/products');
})->name('products.store');

Route::get('/products/{id}', function ($id) {
    $product = (object)['id' => $id, 'sku' => 'SKU001', 'name' => 'Producto Ejemplo', 'description' => 'Descripción', 'price' => 100, 'stock' => 5, 'min_stock' => 2, 'created_at' => now(), 'updated_at' => now()];
    $recentMovements = collect([]); // Placeholder
    return view('products.show', compact('product', 'recentMovements'));
})->name('products.show');

Route::get('/products/{id}/edit', function ($id) {
    $product = (object)['id' => $id, 'sku' => 'SKU001', 'name' => 'Producto Ejemplo', 'description' => 'Descripción', 'price' => 100, 'stock' => 5, 'min_stock' => 2];
    return view('products.edit', compact('product'));
})->name('products.edit');

Route::put('/products/{id}', function ($id) {
    // Placeholder: redirigir a show
    return redirect("/products/{$id}");
})->name('products.update');

Route::delete('/products/{id}', function ($id) {
    // Placeholder: redirigir a index
    return redirect('/products');
})->name('products.destroy');

// Inventario
Route::get('/inventory/movements', function () {
    $movements = collect([]); // Placeholder
    $products = collect([]); // Placeholder
    return view('inventory.movements', compact('movements', 'products'));
})->name('inventory.movements');

Route::get('/inventory/new-movement', function () {
    $products = collect([]); // Placeholder
    return view('inventory.new-movement', compact('products'));
})->name('inventory.new-movement');

Route::post('/inventory/store-movement', function () {
    // Placeholder: redirigir a movements
    return redirect('/inventory/movements');
})->name('inventory.store-movement');

// Auditoría
Route::get('/audit/logs', function () {
    $logs = collect([]); // Placeholder
    return view('audit.logs', compact('logs'));
})->name('audit.logs');

// Usuarios
Route::get('/users', function () {
    $users = collect([]); // Placeholder
    return view('users.index', compact('users'));
})->name('users.index');

Route::get('/users/create', function () {
    return view('users.create');
})->name('users.create');

Route::post('/users', function () {
    // Placeholder: redirigir a index
    return redirect('/users');
})->name('users.store');

Route::get('/users/{id}/edit', function ($id) {
    $user = (object)['id' => $id, 'name' => 'Usuario Ejemplo', 'email' => 'user@example.com', 'role' => 'employee'];
    return view('users.edit', compact('user'));
})->name('users.edit');

Route::put('/users/{id}', function ($id) {
    // Placeholder: redirigir a index
    return redirect('/users');
})->name('users.update');

Route::delete('/users/{id}', function ($id) {
    // Placeholder: redirigir a index
    return redirect('/users');
})->name('users.destroy');

// Redirigir raíz
Route::get('/', function () {
    return redirect('/dashboard');
});