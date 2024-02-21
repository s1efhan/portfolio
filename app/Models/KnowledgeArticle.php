<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'author',
        'topic_id',
        'content',
        'length',
        'title_img', // Füge das Attribut title_img hinzu
    ];
}
