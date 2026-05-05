<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'matiere',
        'note',
        'semestre',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
