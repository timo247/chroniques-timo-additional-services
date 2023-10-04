<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\PodcastsController;

class EpisodeCreationRequest extends FormRequest
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
        //dd($this->file('audio-file')->getMimeType());
        return [
            'podcast_id' => 'numeric|min:' . $podcastsIdLimits['min'] . '|max:' . $podcastsIdLimits['max'],
            'no' => 'numeric|unique:episodes,no,NULL,id,podcast_id,' . $this->podcast_id,
            'title',
            'description',
            'characters' => 'array',
            'tags' =>  'array',
            'audio-file' => 'mimetypes:audio/mpeg',
        ];
    }
}
