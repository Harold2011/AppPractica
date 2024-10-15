<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'agreement',
        'entry_date',
        'end_date', // Incluimos el nuevo campo
        'program_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
