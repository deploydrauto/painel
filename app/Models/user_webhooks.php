<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_webhooks extends Model
{
    use HasFactory;
    const URLHOOK  = 'https://painel.drautomatizado.com/api/';
    protected $table = 'user_webhooks';

}
