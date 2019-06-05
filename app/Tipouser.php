<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipouser extends Model
{
    protected $fillable = ['nombre','descripcion','activo','borrado'];
    protected $guarded = ['id'];

    public function user()
    {
    	return $this->hasMany(User::class);
    }
}
