<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nav_item'];

    // Weitere Logik des Modells kann hier hinzugefügt werden
}
