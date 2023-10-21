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

    public function store(EpisodeCreationRequest $request)
    {
        $filePathAndName = $this->getFilePathAndName($request->input('podcast_id'), $request->input('no'));
        Storage::putFileAs($filePathAndName['path'], $request->file('audio-file'), $filePathAndName['name']);
        $episode = new Episode();
        $episode->podcast_id = $request->input('podcast_id');
        $episode->no = $request->input('no');
        $episode->title = $request->input('title');
        $episode->description = $request->input('description');
        $episode->file_url = $filePathAndName['path'];
        $episode->file_name = $filePathAndName['name'];
        $episode->save();
        //Ajouter les personnages affiliés à l'épisode
        if ($request->input('characters') != null) {
            try {
                Character::findOrFail($request->input('characters'));
                $episode->characters()->attach($request->input('characters'));
            } catch (ModelNotFoundException $e) {
                return response()->json(['message' => $e->getMessage()], 404); // Réponse d'erreur HTTP 404
            }
        }
        //Ajouter les tags affiliés à l'épisode
        if ($request->input('tags') != null) {
            try {
                Tag::findOrFail($request->input('tags'));
                $episode->tags()->attach($request->input('tags'));
            } catch (ModelNotFoundException $e) {
                return response()->json(['message' => $e->getMessage()], 404); // Réponse d'erreur HTTP 404
            }
        }
        return response()->json(['message' => 'episode created successfully', 'episode' => $episode], 404);
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
        //Caution, if user updates an episode number for an already existing episode, ancient episode file will be deleted.
        //dd($request);
        try {
            $episode = Episode::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404); // Réponse d'erreur HTTP 404
        }
        if ($request->filled('no')) {
            if ($episode->no != $request->input('no')) {
                if (Episode::where('no', '=', $request->input('no'))->get() != null) {
                    //appeler fonction qui backup data, fichier puis propose la réaffectation des données de l'épisode
                    $this->backupUpdatedEpisodeFile($request->input('podcast_id'), $request->input('no'));
                }
                $this->renameEpisodeFile($request->input('podcast_id'), $episode->no, $request->input('no'));
                $episode->no = $request->input('no');
            }
        }
        if ($request->filled('title')) {
            $episode->title = $request->input('title');
        }
        if ($request->filled('description')) {
            $episode->description = $request->input('description');
        }

        if ($request->hasFile('audio-file')) {
            $ancientPathAndName = $this->getFilePathAndName($episode->podcast_id, $episode->no);
            if (Storage::exists($ancientPathAndName['path'] . '/' . $ancientPathAndName['name'])) {
                Storage::delete($ancientPathAndName['path'] . '/' . $ancientPathAndName['name']);
            }
            $newPathAndName = $this->getFilePathAndName($request->input('podcast_id'), $episode->no);
            Storage::putFileAs($newPathAndName['path'], $request->file('audio-file'), $newPathAndName['name']);
        }
        $episode->save();

        // Vous pouvez également ajouter ici la logique pour mettre à jour les personnages et les tags affiliés à l'épisode si nécessaire.

        // Rediriger l'utilisateur ou retourner une réponse appropriée
        return response()->json(['message' => 'episode updated successfully', 'episode' => $episode], 404);
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
        $filePath = 'audio' . DIRECTORY_SEPARATOR . 'podcasts' . DIRECTORY_SEPARATOR  . $podcastName;
        $fileName = $podcastName . '-' . $episodeNo . '.mp3';
        return ['path' => $filePath, 'name' => $fileName];
    }

    //Check if a file is linked to an episode which number is being updated. If so, a backup is made for eventual future purpose.
    public function backupUpdatedEpisodeFile($podcastId, $no)
    {
        $filePathAndName = $this->getFilePathAndName($podcastId, $no);
        if (Storage::exists($filePathAndName['path'] . '/' . $filePathAndName['name'])) {
            Storage::move($filePathAndName['path'] . '/' . $filePathAndName['name'], $filePathAndName['path'] . '/' . 'backup-' . $filePathAndName['name']);
        }
        //Si l'épisode avait un numéro existant, sauvegarder les données de l'épisode dans un fichier, puis supprimer l'élément de la base de données

        //Envoyer une alerte pour signifier que deux épisodes ont le même numéro, et indiquer le chemin du fichier sauvegardé en backup
    }

    public function renameEpisodeFile($podcastId, $ancientNo, $newNo)
    {
        $ancientPathAndName = $this->getFilePathAndName($podcastId, $ancientNo);
        $newPathAndName = $this->getFilePathAndName($podcastId, $newNo);
        if (Storage::exists($ancientPathAndName['path'] . '/' . $ancientPathAndName['name'])) {
            Storage::move($ancientPathAndName['path'] . '/' . $ancientPathAndName['name'], $newPathAndName['path'] . '/' . $newPathAndName['name']);
        }
    }
}
