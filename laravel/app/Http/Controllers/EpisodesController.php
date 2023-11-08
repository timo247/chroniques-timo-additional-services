<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Theme;
use App\Models\Episode;
use App\Models\Podcast;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;
use App\Http\Requests\EpisodeUpdateRequest;
use App\Http\Requests\EpisodeCreationRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class EpisodesController extends Controller
{
    //Return a specific episode if id is specified, all episodes of one podcast if serial id is specified or all episodes if none is specified
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
        if ($request->input('tags') != null) {
            foreach ($request->input('tags') as $tag) {
                $tagModel = Tag::where('id', '=', $tag)->first();
                $episode->tags()->attach($tagModel);
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
        $cautionMessage = "false";
        try {
            $episode = Episode::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
        if ($request->filled('no')) {
            $cautionMessage = $this->handleEpisodeNoInput($episode, $request);
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
        if ($request->input('tags') != null) {
            $this->handleTagsChange($episode, $request);
        }
        $episode->save();
        return response()->json(['message' => 'episode updated successfully', 'episode' => $episode, "warning" => $cautionMessage], 404);
    }

    public function destroy($id)
    {
        try {
            $episode = Episode::findOrFail($id);
            $episode->delete();
            return response()->json(['message' => 'Episode with id = ' . $id . ' deleted successfully.'], 404);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
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

    //Handle changes in DB and audio file storage for the episode depending on the no sent and sends a caution message if a file has been backed up and or if some data is now affected to no file in DB.
    public function handleEpisodeNoInput($episode, $request)
    {
        $cautionMessageToSend = false;
        $fileManagementMessage = "";
        $dataBackupMessage = "";
        // abs handles the case of affecting an anciently -n number to a n number. Eg: i update an Episode with -44 value to 44
        if ($episode->no != $request->input('no')) {
            $cautionMessageToSend = true;
            $existingEpisodes = Episode::where('no', '=', $request->input('no'))->get();
            if ($existingEpisodes->count() > 0) {
                foreach ($existingEpisodes as $existingEpisode) {
                    $existingEpisode->update(['no' => -$existingEpisode->no]);
                    $dataBackupMessage .= 'A data for episode ' .  abs($existingEpisode->no) . ' already existed and is now stored in DB as:' . BaseController::modelToReadableString($existingEpisode) . ".\n";
                }
                if (abs($episode->no) != abs($request->input('no'))) {
                    $this->backupUpdatedEpisodeFile($request->input('podcast_id'), $request->input('no'));
                    $fileManagementMessage .= 'A file with number ' . $request->input('no') . ' existed and is now stored with \'backup-\' prefix.' . "\n";
                }
            }
            $this->renameEpisodeFile($request->input('podcast_id'), $episode->no, $request->input('no'));
            $fileManagementMessage .= 'The episode file has been renamed and now ends with. ' . $request->input('no') . '.';
            $episode->no = $request->input('no');
        }
        if ($cautionMessageToSend) {
            return $dataBackupMessage . $fileManagementMessage;
        } else {
            return 'false';
        }
    }

    //Make a backup for an episode file being replaced by another by addin backup- as prefix to its name.
    public function backupUpdatedEpisodeFile($podcastId, $no)
    {
        $filePathAndName = $this->getFilePathAndName($podcastId, $no);
        if (Storage::exists($filePathAndName['path'] . '/' . $filePathAndName['name'])) {
            Storage::move($filePathAndName['path'] . '/' . $filePathAndName['name'], $filePathAndName['path'] . '/' . 'backup-' . $filePathAndName['name']);
        }
    }

    //Affects a new name to an already stored episode 
    public function renameEpisodeFile($podcastId, $ancientNo, $newNo)
    {
        $ancientPathAndName = $this->getFilePathAndName($podcastId, $ancientNo);
        $newPathAndName = $this->getFilePathAndName($podcastId, $newNo);
        if (Storage::exists($ancientPathAndName['path'] . '/' . $ancientPathAndName['name'])) {
            Storage::move($ancientPathAndName['path'] . '/' . $ancientPathAndName['name'], $newPathAndName['path'] . '/' . $newPathAndName['name']);
        }
    }

    public function handleTagsChange($episode, $request)
    {
        $affiliatedTags = $episode->tags()->get();
        foreach ($affiliatedTags as $affiliatedTag) {
            $episode->tags()->detach($affiliatedTag);
        }
        foreach ($request->input('tags') as $tag) {
            $tagModel = Tag::where('id', '=', $tag)->first();
            $episode->tags()->attach($tagModel);
        }
    }
}
