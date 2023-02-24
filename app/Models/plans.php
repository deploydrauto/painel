<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plans extends Model
{
    use HasFactory;
    protected $table = 'plans';
    protected $fillable = ['name', 'price', 'description', 'status', 'created_at', 'updated_at'];
    
}
