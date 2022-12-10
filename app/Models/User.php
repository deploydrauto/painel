<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\models\user_games;
use App\models\user_webhooks;
use App\models\client_bots;
use App\models\clients_per_game;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function games()
    {
        return $this->hasMany(user_games::class);
    }
    public function webhooks()
    {
        return $this->hasMany(user_webhooks::class);
    }
    public function clientes()
    {
        return $this->belongsToMany(client_bots::class);
    }
    public function clients_per_game()
    {
        return $this->hasMany(clients_per_game::class);

    }
}
