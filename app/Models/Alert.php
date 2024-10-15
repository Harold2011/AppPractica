<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    // Especificamos la tabla asociada, aunque no es necesario si el nombre sigue la convención
    protected $table = 'alert';

    // Los campos que se pueden asignar masivamente
    protected $fillable = ['user_id', 'date'];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
