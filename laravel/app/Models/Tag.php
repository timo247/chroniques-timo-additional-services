<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = "tags";

    protected $fillable = [
        'name',
        'value'
    ];

    public static $rules = [
        'name' => 'required|string|regex:/^[a-z\-]+$/|unique:tags', // Only regular chars, minuscules and '-'
    ];

    public function episodes()
    {
        return $this->belongsToMany(Episode::class, 'episode_tag', 'tag_id', 'episode_id')
            ->withTimestamps();
    }
}
