<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artistas extends Model
{
    use HasFactory;
    public function Eventos(){
        return $this->belongsToMany(Eventos::class, "eventos_id", "id");
    }
}
