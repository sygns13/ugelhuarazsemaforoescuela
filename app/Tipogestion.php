<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipogestion extends Model
{
    protected $fillable = ['descripcion','activo','borrado'];
    protected $guarded = ['id'];

    public function datoscolegio()
    {
    	return $this->hasMany(Datoscolegio::class);
    }
}
