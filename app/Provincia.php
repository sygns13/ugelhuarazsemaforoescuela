<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $fillable = ['nombre','codigo','activo','borrado','departamento_id'];
    protected $guarded = ['id'];

    public function departamento()
    {
        return $this->belongsTo('App\Departamento');
    }

    public function distrito()
    {
    	return $this->hasMany(Distrito::class);
    }
}
