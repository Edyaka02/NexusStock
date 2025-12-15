<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\InventoryMovement;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        // Traemos historial ordenado por fecha descendente
        $recentMovements = InventoryMovement::where('product_id', $id)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        return view('products.show', compact('product', 'recentMovements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'min_stock' => 'integer'
        ]);

        $product = Product::create($request->all());

        // Auditoría
        AuditLog::create([
            'event_type' => 'CREATE_PRODUCT',
            'description' => "Se creó el producto {$product->name} (SKU: {$product->sku})",
            'severity' => 'low',
            // No mandamos created_at, SQL Server pone GETDATE()
        ]);

        return redirect()->route('products.index')->with('success', 'Producto creado correctamente');
    }

    // TRANSACCIÓN DE COMPRA/VENTA
    public function transaction(Request $request)
    {
        $request->validate([
            'sku' => 'required|exists:products,sku',
            'type' => 'required|in:purchase,sale', 
            'quantity' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $product = Product::where('sku', $request->sku)->first();
            
            // Lógica de Stock
            if ($request->type == 'sale') {
                if ($product->stock < $request->quantity) {
                    return back()->with('error', 'Stock insuficiente para la venta');
                }
                $product->stock -= $request->quantity;
            } else {
                $product->stock += $request->quantity;
            }
            
            $product->save(); // Esto actualizará 'updated_at' automáticamente

            // Registrar movimiento
            InventoryMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id() ?? 1, // Usa el usuario logueado o el ID 1 (Admin)
                'type' => $request->type,
                'quantity' => $request->quantity
                // created_at lo pone SQL Server
            ]);

            // Auditoría
            AuditLog::create([
                'event_type' => 'TRANSACTION',
                'description' => "Transacción: {$request->type} de {$request->quantity} unidades para {$product->name}",
                'severity' => 'medium'
            ]);

            DB::commit();
            return back()->with('success', 'Transacción registrada con éxito');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
