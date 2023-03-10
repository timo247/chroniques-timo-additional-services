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
        $podcastsIdLimits = PodcastsController::maxMinPodcastsId();
        return [
            'podcast_id' => 'numeric|min:' . $podcastsIdLimits['min'] . '|max:' . $podcastsIdLimits['max'],
            'no' => 'numeric|unique:episodes,no,NULL,id,podcast_id,' . $this->podcast_id,
            'title',
            'characters' => 'array',
            'tags' =>  'array',
            'file' => 'mimes:audio/mp3',
        ];
    }
}
