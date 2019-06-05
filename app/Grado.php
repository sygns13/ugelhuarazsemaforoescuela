<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
	protected $fillable = ['nombre','activo','borrado','datoscolegio_id'];
    protected $guarded = ['id'];

    public function datoscolegio()
    {
        return $this->belongsTo('App\Datoscolegio');
    }

    public function seccion()
    {
        return $this->hasMany(Seccion::class);
    }
}
