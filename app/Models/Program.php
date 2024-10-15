<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $table = 'program';
    protected $fillable = ['name', 'ficha'];

    // Relación con InfoStudent
    public function students()
    {
        return $this->hasMany(InfoStudent::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher', 'program_id', 'user_id');
    }

    public function coordinators()
    {
        return $this->belongsToMany(User::class, 'coordinator', 'program_id', 'user_id');
    }

    public function selectAlternatives()
    {
        return $this->hasManyThrough(SelectAlternative::class, InfoStudent::class, 'program_id', 'user_id', 'id', 'user_id');
    }


    public function infostudents()
    {
        return $this->hasMany(InfoStudent::class, 'program_id');
    }
}

