<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeTopic extends Model
{
    use HasFactory;

        protected $fillable = [
            'topic_name',
            'category_id',
        ];
    
        public function category()
        {
            return $this->belongsTo(KnowledgeCategory::class, 'category_id');
        }
}
