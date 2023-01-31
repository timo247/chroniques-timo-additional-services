<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PodcastRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        var_dump($this);
        return [
            "podcast_id" => "numeric",
            "no" => "numeric",
            "title" => "alpha_numeric",
            "characters" => "string",
            "tags" =>  'string',
        ];
    }
}