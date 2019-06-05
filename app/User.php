<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','activo','borrado','tipouser_id','persona_id','token','institucion_id','llenarold'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tipouser()
    {
        return $this->belongsTo('App\Tipouser');
    }
    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }


    public function permiso()
    {
        return $this->hasMany(Permiso::class);
    }
}
