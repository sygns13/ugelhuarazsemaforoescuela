<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Persona extends Model
{
    protected $fillable = ['doc','tipodoc','nombres','apellidos','genero','telefono','direccion','activo','borrado'];
    protected $guarded = ['id'];

    public function personal()
    {
    	return $this->hasMany(Personal::class);
    }
    public function user()
    {
    	return $this->hasMany(User::class);
    }
}
