<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Theme;
use App\Models\Episode;
use App\Models\Podcast;
use App\Models\Character;
use Illuminate\Http\Request;
use App\Http\Requests\EpisodeRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EpisodeUpdateRequest;
use App\Http\Requests\EpisodeCreationRequest;
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

    public function store(Request $request)
    {
        $filePathAndName = $this->getFilePathAndName($request->input('podcast_id'), $request->input('no'));
        // var_dump($filePathAndName);
        // die;
        Storage::putFileAs($filePathAndName['path'], $filePathAndName['name']);
        $episode = new Episode();
        $episode->podcast_id = $request->input('podcast_id');
        $episode->no = $request->input('no');
        $episode->title = $request->input('title');
        $episode->description = $request->input('description');
        $episode->save();
        return response()->json(['message' => 'episode created successfully', 'episode' => $episode], 404);

        //Ajouter les personnages affiliés à l'épisode
        $characters = Character::findOrFail($request->input('characters'));
        $episode->characters()->attach($request->input('characters'));
        //Ajouter les tags affiliés à l'épisode
        $existingTags = Tag::findOrFail($request->input('tags'));
        $episode->tags()->attach($request->input('tags'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(EpisodeUpdateRequest $request, $id)
    {
        $episode = Episode::findOrFail($id);

        if ($request->hasFile('audio-file')) {
            $ancientPathAndName = $this->getFilePathAndName($episode->podcast_id, $episode->no);
            if (Storage::exists($ancientPathAndName['path'] . '/' . $ancientPathAndName['name'])) {
                Storage::delete($ancientPathAndName['path'] . '/' . $ancientPathAndName['name']);
            }
            $podcastName = PodcastsController::retrievePodcastName($episode->podcast_id);
            $fileName = $podcastName . '-' . $request->input('no') . '.mp3';
            $filePath = 'audio/podcasts/' . $podcastName;
            Storage::putFileAs($filePath, $request->file('audio-file'), $fileName);
            $episode->audio_filename = $fileName;
            $episode->path = $filePath;
        }
        if ($request->filled('no')) {
            $episode->no = $request->input('no');
        }
        if ($request->filled('title')) {
            $episode->title = $request->input('title');
        }
        if ($request->filled('description')) {
            $episode->description = $request->input('description');
        }
        // Enregistrer les modifications de l'épisode
        $episode->save();

        // Vous pouvez également ajouter ici la logique pour mettre à jour les personnages et les tags affiliés à l'épisode si nécessaire.

        // Rediriger l'utilisateur ou retourner une réponse appropriée
        return redirect()->route('votre_route_de_vue', ['id' => $episode->id])->with('success', 'Épisode mis à jour avec succès');
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

    public function getFilePathAndName($podcastId, $episodeNo)
    {
        $podcastName = PodcastsController::retrievePodcastName($podcastId);
        $filePath = storage_path('app/audio/podcasts/' . $podcastName);
        $fileName = $podcastName . '-' . $episodeNo . '.mp3';
        return ['path' => $filePath, 'name' => $fileName];
    }
}
