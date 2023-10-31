<?php

namespace App\Rules;

use Closure;
use App\Models\Tag;
use Illuminate\Contracts\Validation\Rule;

class ExistingTags implements Rule
{
    public function passes($attribute, $value)
    {
        // Convertissez la valeur en un tableau s'il ne l'est pas déjà
        $tags = is_array($value) ? $value : [$value];

        // Vérifiez si tous les tags existent dans la base de données
        return Tag::whereIn('id', $tags)->count() === count($tags);
    }

    public function message()
    {
        return 'Tous les tags doivent exister dans la base de données.';
    }
}
