<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectAlternative extends Model
{
    use HasFactory;

    protected $table = 'select_alternative'; // Especificamos el nombre de la tabla

    protected $fillable = [
        'user_id',
        'alternative_id',
        'description',
    ];

    // Definir las relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }
}
