<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\PodcastsController;

class EpisodeUpdateRequest extends FormRequest
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
        //dd($this->input('tags'), $podcastsIdLimits);
        return [
            'id' => 'exists:episodes,id',
            'podcast_id' => 'integer|min:' . $podcastsIdLimits['min'] . '|max:' . $podcastsIdLimits['max'],
            'no' => 'nullable|integer',
            'title' => 'nullable',
            'description' => 'nullable',
            'spotify_uri' => 'alpha_num',
            'tags' => 'nullable|array',
            'audio-file' => 'mimetypes:audio/mpeg|nullable',
            'sound_quality_rating' => 'nullable|integer|min:1|max:5',
            'content_quality_rating' => 'nullable|integer|min:1|max:5'
        ];
    }
}
