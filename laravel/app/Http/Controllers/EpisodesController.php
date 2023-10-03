<?php

namespace App\Http\Controllers;

use App\Http\Requests\EpisodeRequest;
use App\Models\Tag;
use App\Models\Theme;
use App\Models\Episode;
use App\Models\Podcast;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class EpisodesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('episode_id') == null) {
            if ($request->input('serial_id') != null) {
                $podcasts = Episode::where('podcast_id', '=', $request->input('serial_id'))->get()->toArray();
            } else {
                $podcasts = Episode::get()->toArray();
            }
            return response()
                ->json(['message' => 'podcasts successfully retrieved', 'data' => $podcasts]);
        } else {
            $podcast = Episode::where('id', '=', $request->input('episode_id'))->firstOrFail();
            return response()
                ->json(['message' => 'podcast successfully retrieved', 'data' => $podcast]);
        }
    }

    public function create()
    {
        $possiblePodcasts = Podcast::get()->toArray();
        $possibleThemes = $this->possibleThemes();
        $possibleCharacters = $this->possibleCharacters();
        return view('/episodes/view_create_episode')->with(['possiblePodcasts' => $possiblePodcasts, 'possibleThemes' => $possibleThemes, 'possibleCharacters' => $possibleCharacters]);
    }

    public function store(EpisodeRequest $request)
    {
        $podcastName = $this->retrievePodcastName($request->input('podcast_id'));
        $fileName = $podcastName . '-' . $request->input('no') . '.mp3';
        $filePath = 'audio/podcasts/' . $podcastName;
        //Storage::putFileAs($filePath, $request->file('audio-file'), $fileName);
        $episode = new Episode();
        $episode->podcast_id = $request->input('podcast_id');
        $episode->no = $request->input('no');
        $episode->title = $request->input('title');
        $episode->description = $request->input('description');
        $episode->path = $filePath;
        $episode->save();

        //Ajouter les personnages affiliés à l'épisode
        $characters = Character::findOrFail($request->input('characters'));
        $episode->characters()->attach($request->input('characters'));
        //Ajouter les tags affiliés à l'épisode
        $existingTags = Tag::findOrFail($request->input('tags'));
        $episode->tags()->attach($request->input('tags'));
        dd($episode->tags);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    function update(Request $request, $id)
    {
        Podcast::findOrFail($id)->update($request->all());
        return redirect('user')->withOk("L'utilisateur " . $request->input('name') .
            " a été modifié");
    }

    public function destroy($id)
    {
        //
    }




    public static function possibleThemes()
    {
        $possibleThemes = Theme::get()->toArray();
        return $possibleThemes;
    }

    public static function possibleCharacters()
    {
        $possibleCharacters = Character::get()->toArray();
        return $possibleCharacters;
    }
}
