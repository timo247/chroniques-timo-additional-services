<?php

namespace App\Http\Requests;

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
        return [
            'podcast_id' => 'numeric|min:' . $podcastsIdLimits['min'] . '|max:' . $podcastsIdLimits['max'],
            'no' => 'required|numeric|unique:episodes,no,NULL,id,podcast_id,' . $this->podcast_id,
            'title' => 'required',
            'description' => 'nullable',
            'characters' => 'nullable|array',
            'tags' => 'nullable|array',
            'audio-file' => 'required|mimetypes:audio/mpeg',
            'spotify_uri' => 'required|alpha_num'
        ];
    }
}