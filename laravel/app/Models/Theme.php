<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;
    protected $table = "themes";
    protected $fillable = [
        "value"
    ];

    public function episodes()
    {
        return $this->belongsToMany(Episode::class);
    }
}
