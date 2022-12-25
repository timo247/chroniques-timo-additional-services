<?php

namespace App\Models;

use App\Models\Episode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Podcast extends Model
{
    use HasFactory;
    protected $table = "podcasts";
    protected $fillable = [
        "title"
    ];

    public function episodes(){
        return $this->hasMany(Episode::class);
    }
}
