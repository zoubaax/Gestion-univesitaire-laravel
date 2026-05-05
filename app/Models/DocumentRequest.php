<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = ['etudiant_id', 'type', 'status', 'admin_note'];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
