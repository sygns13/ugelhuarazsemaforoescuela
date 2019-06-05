<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipodia extends Model
{
    protected $fillable = ['dia','numdia','activo','borrado'];
    protected $guarded = ['id'];

    public function configdia()
    {
    	return $this->hasMany(Configdia::class);
    }
}
