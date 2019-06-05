<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feriado extends Model
{	
	 protected $table = "feriados";
    protected $fillable = ['nombre','fecha','years','activo', 'borrado'];
    protected $guarded = ['id'];
    
}
