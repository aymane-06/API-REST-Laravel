<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competences extends Model
{
    /** @use HasFactory<\Database\Factories\CompetencesFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
    public function user()
    {
        return $this->belongsToMany(User::class, 'competence_user');
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
