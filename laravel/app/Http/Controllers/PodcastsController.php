<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Episode;
use App\Models\Podcast;
use App\Models\Character;
use Illuminate\Http\Request;
use App\Http\Requests\PodcastRequest;
use Illuminate\Support\Facades\Storage;

class PodcastsController extends Controller
{
    public function index(Request $request)
    {
        $serialId = $request->input('serial_id');
        $podcastId = $request->input('episode_id');
        if ($podcastId == null) {
            if ($serialId != null) {
                $podcasts = Episode::where('podcast_id', '=', $serialId)->get()->toArray();
            } else {
                $podcasts = Episode::get()->toArray();
            }
            //dd($podcasts);
            return response()
                ->json(['message' => 'podcasts successfully retrieved', 'data' => $podcasts]);
        } else {
            $podcast = Episode::where('id', '=', $podcastId)->firstOrFail();
            return response()
                ->json(['message' => 'podcast successfully retrieved', 'data' => $podcast]);
        }
        //dd($podcasts);

    }

    public function create()
    {
        $possiblePodcasts = Podcast::get()->toArray();
        $possibleThemes = $this->possibleThemes();
        $possibleCharacters = $this->possibleCharacters();
        // foreach ($possiblePodcasts as $podcast) {
        //     array_push($possiblePodcastIds, $podcast['id']);
        // }
        return view('/episodes/view_create_episode')->with(['possiblePodcasts' => $possiblePodcasts, 'possibleThemes' => $possibleThemes, 'possibleCharacters' => $possibleCharacters]);
    }

    public function store(PodcastRequest $request)
    {
        dd($request->file('audio-file'));
        $podcastName = $this->retrievePodcastName($request->input('podcast_id'));
        //dd($podcastName);
        $fileName = $podcastName . '-' . $request->input('no');
        $filePath = 'audio/podcasts/' . $podcastName . '/' . $fileName;
        dd($filePath, $request->input('audio-file'));
        Storage::putFileAs($filePath, $request->input('file'), $podcastName);
        $episode = new Episode();
        $episode->podcast_id = $request->input('podcast_id');
        $episode->no = $request->input('no');
        $episode->title = $request->input('title');
        $episode->description = $request->input('description');
        $episode->path = $filePath;
        $episode->save();
        dd($episode);
    }

    // public function store(ConsommationRequest $request)
    //     {
    //         $input = $request->input();
    //         //dd($request->file('image'));

    //         $lastIndexedConso = Consommation::orderBy('id', 'desc')->limit('1')->get();
    //         $newIndex = $lastIndexedConso[0]->id + 1;


    //        $fileName = 'image-'.'etablissement-'.$input["etablissement_id"]."-consommation-".$newIndex.".png";  

    //         $image = $request->file('image');
    //         if($image!=null){
    //         Storage::putFileAs('images', $image, $fileName);
    //         }

    //         $consommation = new Consommation();

    //         $consommation->nom = $input["nom"];
    //         $consommation->description = $input["description"];
    //         $consommation->image_url = $fileName;
    //         $consommation->categorie = $input["categorie"];
    //         $consommation->prix =  $input["prix"];
    //         $consommation->tags = $input["tags"];
    //         $consommation->etablissement_id = $input["etablissement_id"];

    //         //dd($consommation);
    //         //dd($consommation);
    //         $consommation->save();
    //         return view('view_confirmation_creation_consommation')->with('etablissementId', $input['etablissement_id']);
    //     }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function retrievePodcastName($podcastId)
    {
        $podcastNames = ['chroniques-economiques', 'digitime', 'anbu-savana'];
        return $podcastNames[$podcastId - 1];
    }

    public static function maxMinPodcastsId()
    {
        $podcasts = Podcast::select('id')->get()->toArray();
        $arr = [];
        foreach ($podcasts as $podcast) {
            array_push($arr, $podcast['id']);
        }
        $possibleIdLimits = [
            'min' => min($arr),
            'max' => max($arr)
        ];
        return $possibleIdLimits;
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
