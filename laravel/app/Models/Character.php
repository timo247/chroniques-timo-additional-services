<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;
    protected $table = "characters";
    protected $fillable = [
        "name"
    ];

    public function episodes()
    {
        return $this->belongsToMany(Episode::class);
    }
}
