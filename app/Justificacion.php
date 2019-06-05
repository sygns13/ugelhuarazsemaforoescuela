<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Justificacion extends Model
{
    protected $fillable = ['nombre','descripcion','rutafile','activo','borrado','estado','fecha','personals_id','fechaini','fechafin'];
    protected $guarded = ['id'];

    public function personal()
    {
        return $this->belongsTo('App\Personal');
    }
}
