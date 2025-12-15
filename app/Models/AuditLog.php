<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';
    protected $guarded = [];

    // Desactivamos timestamps porque no existe 'updated_at' en SQL
    public $timestamps = false;
}
