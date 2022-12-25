<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Podcast;
use Illuminate\Http\Request;
use App\Http\Requests\PodcastRequest;

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
        //
    }

    public function store(PodcastRequest $request)
    {
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
}