<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Storage;
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
        //dd($this->input('podcast_id'), $podcastsIdLimits);
        return [
            'podcast_id' => 'numeric|min:' . $podcastsIdLimits['min'] . '|max:' . $podcastsIdLimits['max'],
            'no' => 'nullable|numeric',
            'title' => 'nullable',
            'description' => 'nullable',
            'characters' => 'nullable|array',
            'tags' => 'nullable|array|exists:tags,id',
            'audio-file' => 'nullable|mimetypes:audio/mpeg',
        ];
    }
}
