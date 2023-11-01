<?php

namespace App\Rules;

use Closure;
use App\Models\Tag;
use Illuminate\Contracts\Validation\Rule;

class ExistingTags implements Rule
{
    // Verify if tags already exist in DB
    public function passes($attribute, $value)
    {
        $tags = is_array($value) ? $value : [$value];
        return Tag::whereIn('id', $tags)->count() === count($tags);
    }

    public function message()
    {
        return 'Each tag must exist in Database';
    }
}
