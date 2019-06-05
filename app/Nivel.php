<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $fillable = ['descripcion','nivel','activo','borrado'];
    protected $guarded = ['id'];

    public function datoscolegio()
    {
        return $this->hasMany(Datoscolegio::class);
    }
}
