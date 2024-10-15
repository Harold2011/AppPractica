<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    use HasFactory;

    protected $table = 'coordinator'; // Asegúrate de que el nombre de la tabla sea correcto

    protected $fillable = ['user_id', 'program_id'];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Program
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'coordinator', 'user_id', 'program_id')
                    ->withTimestamps();
    }

}
