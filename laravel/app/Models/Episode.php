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
        "title",
        "description",
        "path",
        "tags",
        "characters"
    ];

    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'episode_tag', 'episode_id', 'tag_id')
            ->withTimestamps();
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class, 'character_episode', 'character_id', 'episode_id')
            ->withTimestamps();
    }
}
