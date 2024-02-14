<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Play;
use App\Models\Episode;
use App\Models\Podcast;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\BaseController;
use App\Http\Requests\EpisodeUpdateRequest;
use App\Http\Requests\AddEpisodePlayRequest;
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
            // Log::info('how data is treated', [
            //     "we are in the episodes controller", $podcasts
            // ]);
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
        $episode->spotify_uri = $request->input('spotify_uri');
        $episode->sound_quality_rating =  $request->input('sound_quality_rating');
        $episode->content_quality_rating =  $request->input('content_quality_rating');
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
                $tagModel = Tag::firstOrCreate(['value' => $tag], ['name' => BaseController::cleanCaseString($tag)]);
                $episode->tags()->attach($tagModel);
            }
        }
        return response()->json(['message' => 'episode created successfully', 'episode' => $episode], 201);
    }

    public function show($id)
    {
        $episode = Episode::with('tags')
            ->where('id', '=', $id)
            ->firstOrFail();
        return view('/episodes/view_display_episode')->with('episode', $episode);
    }

    public function edit($id)
    {
        $episode = Episode::where('id', '=', $id)->firstOrFail();
        $tags = $episode->tags;
        $possiblePodcasts = Podcast::get()->toArray();
        $possibleThemes = $this->possibleThemes();
        return view('/episodes/view_edit_episode')->with(['episode' => $episode, 'possibleThemes' => $possibleThemes, 'tags' => $tags, 'possiblePodcasts' => $possiblePodcasts]);
    }

    public function update(EpisodeUpdateRequest $request)
    {
        $numberCautionMessage = "";
        $podcastCautionMessage = "";
        //dd("ici");
        try {
            $episode = Episode::findOrFail($request->input('id'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
        if ($request->filled('no')) {
            $numberCautionMessage = $this->handleEpisodeNoInput($episode, $request);
        }
        if ($request->input('podcast_id')) { //put after input->no handling on purpose
            $podcastCautionMessage = $this->handlePodcastIdInput($episode, $request);
        }
        if ($request->filled('title')) {
            $episode->title = $request->input('title');
        }
        if ($request->filled('description')) {
            $episode->description = $request->input('description');
        }
        if ($request->filled('spotify_uri')) {
            $episode->spotify_uri = $request->input('spotify_uri');
        }
        if ($request->filled('sound_quality_rating')) {
            $episode->sound_quality_rating =  $request->input('sound_quality_rating');
        }
        if ($request->filled('content_quality_rating')) {
            $episode->content_quality_rating =  $request->input('content_quality_rating');
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
            //add all unlinked tags to episode
            foreach ($request->input('tags') as $tag) {
                $tagModel = Tag::firstOrCreate(['value' => $tag], ['name' => BaseController::cleanCaseString($tag)]);
                if (!$episode->tags->contains($tagModel)) {
                    $episode->tags()->attach($tagModel);
                }
            }
            //Remove all linked episode not in the request
            foreach ($episode->tags as $tag) {
                if (!in_array($tag->value, $request->input('tags'))) {
                    $episode->tags()->detach($tag);
                }
            }
        }
        $episode->save();
        return response()->json(['message' => 'episode updated successfully', 'episode' => $episode, "warning" => $numberCautionMessage . ',' . $podcastCautionMessage], 404);
    }

    public function destroy($id)
    {
        try {
            $episode = Episode::findOrFail($id);
            $episode->delete();
            return response()->json(['message' => 'Episode with id = ' . $id . ' deleted successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function getPlays()
    {
        $plays = DB::table('plays')->get()->toArray();
        return response()->json(['message' => 'plays retrieved successfully', 'data' => $plays], 200);
    }

    public function getUserPlays($userId)
    {
        $plays = DB::table('plays')->where('user_id', '=', $userId)->get()->toArray();
        return response()->json(['message' => 'user with id = ' . $userId . ' plays retrieved successfully', 'data' => $plays], 200);
    }

    public function addEpisodePlay(AddEpisodePlayRequest $request)
    {

        $play = Play::where('user_id', '=', $request->user()->id)->where('episode_id', '=', $request->episode_id)->first();
        if ($play == null) {
            $play = new Play();
            $play->episode_id = $request->episode_id;
            $play->user_id = $request->user()->id;
            $play->nb_plays = 1;
            $play->save();
        } else {
            $play->nb_plays += 1;
            $play->save();
            return response()->json(['message' => 'play for user with id = ' . $request->user()->id . ' with episode with id = ' . $request->episode_id . ' updated successfully', 'data' => $play], 200);
        }
        return response()->json(['message' => 'play for user with id = ' . $request->user()->id . ' with episode with id = ' . $request->episode_id . ' created successfully', 'data' => $play], 200);
    }

    public static function possibleThemes()
    {
        $possibleThemes = Tag::get()->toArray();
        return $possibleThemes;
    }

    public static function possibleCharacters()
    {
        $possibleCharacters = Character::get()->toArray();
        return $possibleCharacters;
    }

    /*
    Handle te application of changes for episode number in database and audio file.
    Audio files are stored this way: audio/<podcast_name>/<podcast_name>-<episode_no>.mp3
    If an episode's number is changed for a number already affected ot another episode for the same podcast, the data of the erased episode is saved with a number = -1*number, so it can be filtered when getting the list of episodes of a podcast
    The previous file previously linked to the episode number is then stored as audio/<podcast_name>/backup-<podcast_name>-<episode_no>.mp3
    The new file for episode is then stored as audio/podcast_name/<podcast_name>-<episode_no>.mp3
    */
    public function handleEpisodeNoInput($episode, $request)
    {
        $cautionMessageToSend = false;
        $fileManagementMessage = "";
        $dataBackupMessage = "";
        // abs handles the case of affecting an anciently -n number to a n number. Eg: i update an Episode with -44 value to 44
        if ($episode->no != $request->input('no')) {
            $cautionMessageToSend = true;
            $existingEpisodes = Episode::where('no', '=', $request->input('no'))->where('podcast_id', '=', $episode->podcast_id)->get();
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
            $this->renameEpisodeFile($episode->podcast_id, $episode->podcast_id, $episode->no, $request->input('no'));
            $fileManagementMessage .= 'The episode file has been renamed and now ends with. ' . $request->input('no') . '.';
            $episode->no = $request->input('no');
        }
        if ($cautionMessageToSend) {
            return $dataBackupMessage . $fileManagementMessage;
        } else {
            return 'false';
        }
    }

    /*
    Handle te application of changes when affecting an episode to another podcast in DB and files. 
    Audio files are stored this way: audio/<podcast_name>/<podcast_name>-<episode_no>.mp3
    If an episode's podcast is changed for a podcast where an episode with the same number already existed, the data of the erased episode is saved with a number = -1*number, so it can be filtered when getting the list of episodes of a podcast
    The previous file previously linked to the episode number is then stored as audio/<podcast_name>/backup-<podcast_name>-<episode_no>.mp3
    The new file for episode is then stored as audio/podcast_name/<podcast_name>-<episode_no>.mp3
    */
    public function handlePodcastIdInput($episode, $request)
    {
        $cautionMessageToSend = false;
        $fileManagementMessage = "";
        $dataBackupMessage = "";
        $podcastName = PodcastsController::retrievePodcastName($request->input('podcast_id'));
        // abs handles the case of affecting an anciently -n number to a n number. Eg: i update an Episode with -44 value to 44
        if ($episode->podcast_id != $request->input('podcast_id')) {
            $cautionMessageToSend = true;
            $existingEpisodes = Episode::where('no', '=', $episode->no)->where('podcast_id', '=', $request->input('podcast_id'))->get();
            if ($existingEpisodes->count() > 0) {
                foreach ($existingEpisodes as $existingEpisode) {
                    $existingEpisode->update(['no' => -$existingEpisode->no]);
                    $dataBackupMessage .= 'A data for episode ' .  abs($existingEpisode->no) . 'of podcast: ' . $podcastName . ' already existed and is now stored in DB as:' . BaseController::modelToReadableString($existingEpisode) . ".\n";
                }
                $this->backupUpdatedEpisodeFile($request->input('podcast_id'), $episode->no);
                $fileManagementMessage .= 'A file with podcast id ' . $request->input('podcast_id') . ' existed and is now stored with \'backup-\' prefix.' . "\n";
            }
            $this->renameEpisodeFile($episode->podcast_id, $request->input('podcast_id'), $episode->no, $episode->no);
            $fileManagementMessage .= 'The episode file has been renamed and is now located in folder: /' . $podcastName . '.';
            $episode->podcast_id = $request->input('podcast_id');
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
    public function renameEpisodeFile($ancientPodcastId, $newPodcastId, $ancientNo, $newNo)
    {
        $ancientPathAndName = $this->getFilePathAndName($ancientPodcastId, $ancientNo);
        $newPathAndName = $this->getFilePathAndName($newPodcastId, $newNo);
        if (Storage::exists($ancientPathAndName['path'] . '/' . $ancientPathAndName['name'])) {
            Storage::move($ancientPathAndName['path'] . '/' . $ancientPathAndName['name'], $newPathAndName['path'] . '/' . $newPathAndName['name']);
        }
    }

    public function getFilePathAndName($podcastId, $episodeNo)
    {
        $podcastName = PodcastsController::retrievePodcastName($podcastId);
        $filePath = 'audio' . DIRECTORY_SEPARATOR . 'podcasts' . DIRECTORY_SEPARATOR  . $podcastName;
        $fileName = $podcastName . '-' . $episodeNo . '.mp3';
        return ['path' => $filePath, 'name' => $fileName];
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


    // public function storeEpisodeFromJson(Request $request)
    // {
    //     $data = $request->json()->all();
    //     foreach ($data as $episodeData) {
    //         $episode = new Episode;
    //         $episode->no = $episodeData["no"];
    //         $episode->spotify_uri = $episodeData["spotify_uri"];
    //         $episode->title = $episodeData["title"];
    //         $episode->description = $episodeData["description"];

    //     }
    //     var_dump($episode);
    // }

    public function adminIndex()
    {
        $episodes = Episode::with('tags')
            ->orderBy('updated_at')
            ->paginate(10);
        $links = $episodes->render();
        return view('/episodes/view_list_episodes', compact('episodes', 'links'));
    }
}