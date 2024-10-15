<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipAlternative extends Model
{
    use HasFactory;
    protected $table = 'tip_alternative';

    protected $fillable = ['tip', 'alternative_id'];

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }
}
