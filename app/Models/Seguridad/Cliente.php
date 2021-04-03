<?php

namespace App\Models\Seguridad;;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
      
    protected $fillable = [
        "id",
        "identidad",
        "primer_nombre",
        "segundo_nombre",
        "primer_apellido",
        "segundo_apellido",
        "direccion",
        "telefono",
        "pdf",
        "prestamoactivo",
        "usuario_id"
        ];    
    
}
