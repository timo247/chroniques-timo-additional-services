<?php

namespace App\Models;

use App\Models\Podcast;
use App\Models\Commentaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    use HasFactory;
    protected $table = "episodes";
    protected $fillable = [
        "podcast_id",
        "no",
        "title"
    ];

    public function podcast(){
        return $this->belongsTo(Podcast::class);
    }

    public function commentaires(){
        return $this->hasMany(Commentaire::class);
    }
}
