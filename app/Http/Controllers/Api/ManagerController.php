<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtistManagerRequest;
use App\Http\Requests\UpdateArtistManagerRequest;
use App\Models\ArtistManager;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = auth()->user()->artist->managers;
        return response()->json($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArtistManagerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtistManagerRequest $request)
    {
        $data = $request->all();
        $manager = new ArtistManager;
        $manager->name = $data['name'];
        $manager->artist_id = auth()->user()->artist->id;
        $manager->phone = $data['phone']['prefix']." ".$data['phone']['number'];
        $manager->email = $data['email'] ?? null;
        $manager->save();
        $user = auth()->user()->load("managers");
        return response()->json(auth()->user()->managers);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArtistManager  $manager
     * @return \Illuminate\Http\Response
     */
    public function show(ArtistManager $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ArtistManager $manager
     * @return \Illuminate\Http\Response
     */
    public function edit(ArtistManager $manager)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArtistManagerRequest  $request
     * @param  \App\Models\ArtistManager $manager
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArtistManagerRequest $request, ArtistManager $manager)
    {
        $data = $request->all();
        $data['phone'] = $data['phone']['prefix']." ".$data['phone']['number'];
        $manager->update($data);
        return response()->json($manager);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArtistManager $manager
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArtistManager $manager)
    {
        $manager->delete();
        auth()->user()->load("managers");
        return response()->json(auth()->user()->managers);
    }
}
