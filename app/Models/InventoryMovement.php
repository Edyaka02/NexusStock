<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $table = 'inventory_movements';
    protected $guarded = [];

    // tabla SQL no tiene columna 'updated_at'.
    // Desactivamos timestamps para que Laravel no intente llenar columnas que no existen.
    public $timestamps = false;

    // Relaciones
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
