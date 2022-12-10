<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\models\game_bots;
use App\models\User;

class client_bots extends Model
{
    use HasFactory;
    public function games()
    {
        return $this->hasOne(game_bots::class);
    }
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
