<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest('id')->paginate(10);
        return response()->json($photos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists;products,id',
            'photos' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:512'
        ]);

        foreach ($request->photos as $key => $photo) {
            $newName = $photo->store('public');

            Photo::create([
                'name' => $newName,
                'product_id' => $request->product_id
            ]);
        }

        // Photo::insert($photos);

        return response()->json(['message' => 'Photos are uploaded'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::find($id);
        if (is_null($photo)) {
            return response()->json(['message' => 'Photo is Not Found'], 404);
        }
        Storage::delete($photo->name);
        $photo->delete();

        return response()->json([], 204);
    }
}
