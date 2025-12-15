<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
    // Permitimos llenar todo masivamente
    protected $guarded = [];

    // Tu tabla products SI tiene created_at y updated_at, 
    // así que dejamos que Laravel maneje los tiempos por defecto.
    public $timestamps = true;
}
