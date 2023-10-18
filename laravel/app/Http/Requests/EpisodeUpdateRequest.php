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
        //dd($this->file('audio-file')->getMimeType());
        return [
            'podcast_id' => 'nullable|numeric',
            'no' => 'nullable|numeric|unique:episodes,no,NULL,id,podcast_id,' . $this->podcast_id,
            'title' => 'nullable',
            'description' => 'nullable',
            'characters' => 'nullable|array',
            'tags' =>  'nullable|array',
            'audio-file' => 'nullable|mimetypes:audio/mpeg',
        ];
    }
}
