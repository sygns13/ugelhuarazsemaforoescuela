<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistenciapersonal extends Model
{
    protected $fillable = ['nombre','asistencia','fecha','activo','borrado','tipo','personal_id','configdia_id'];
    protected $guarded = ['id'];

    public function personal()
    {
        return $this->belongsTo('App\Personal');
    }

}
