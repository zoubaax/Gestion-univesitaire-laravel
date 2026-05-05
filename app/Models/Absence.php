<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'module_id',
        'date',
        'justifie',
        'justification_path',
        'commentaire',
    ];

    protected $casts = [
        'date' => 'date',
        'justifie' => 'boolean',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
