<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\PodcastsController;

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
        if (!PodcastsController::verifyPodcastExistence($this->input('podcast_id'))) {
            return false;
        } else {
            return [
                "podcast_id" => "numeric",
                "no" => "numeric",
                "title" => "alpha_numeric",
                "characters" => "string",
                "tags" =>  'string',
                "file" => 'mp3',
            ];
        }
    }
}
