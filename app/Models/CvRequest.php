<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvRequest extends Model
{
    
    use HasFactory;
    protected $fillable = ['email', 'name', 'company', 'position'];
}
