<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagCreationRequest;
use App\Http\Requests\TagUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagsController extends Controller
{

    //Returns tag and list of all episodes related to the tag if tag id specified, or all tags
    public function index(Request $request)
    {
        if ($request->filled('id')) {
            try {
                $tag  = Tag::findOrFail($request->input('id'));
                $episodes = $tag->episodes->toArray();
                return response()
                    ->json(['message' => 'tag episodes successfully retrieved', 'data' => ['tag' => $tag, 'episodes' => $episodes]]);
            } catch (ModelNotFoundException $e) {
                return response()->json(['message' => $e->getMessage()], 404);
            }
        } else {
            $tags = Tag::get()->toArray();
            return response()
                ->json(['message' => 'tags successfully retrieved', 'data' => $tags]);
        }
    }

    public function create()
    {
        //
    }

    public function store(TagCreationRequest $request)
    {
        $tag = Tag::create($request->all());
        $tag->save();
        return response()
            ->json(['message' => 'tag successfully created', 'data' => $tag]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }


    public function update(TagUpdateRequest $request, string $id)
    {
        try {
            $tag = Tag::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }

        if ($request->filled('name')) {
            $tag->name = $request->input('name');
        }

        if ($request->filled('value')) {
            $tag->value = $request->input('value');
        }
        $tag->save();
        return response()
            ->json(['message' => 'tag updated successfully', 'data' => $tag]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();
            return response()->json(['message' => 'Tag with id = ' . $id . ' deleted successfully.'], 404);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
