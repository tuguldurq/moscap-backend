<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Models\Song;
use App\Models\User;
use App\Models\Artist;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'result' => Auth::user()->artist->songs
        ]);
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
     * @param  \App\Http\Requests\StoreSongRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSongRequest $request)
    {
        $song_code = Song::generateCode();
        $datas = $request->all();
        $songData['song_code'] = $song_code;
        $songData['origin_name'] = $datas['origin_name'];
        if(Auth::user()->artist->type == 'A'){
            $songData['author_id'] = Auth::user()->artist->id;
            $user = User::where('first_name', $datas['composer']['first_name'])
                        ->where('last_name', $datas['composer']['last_name'])
                        ->first();
            if($user){
                $songData['composer_id'] = $user->artist->id;
            }else{
                $user = User::create([
                    'first_name' => $datas['composer']['first_name'], 
                    'last_name' => $datas['composer']['last_name'],
                    'phone' => '+976 ',
                    'password' => '123456789',
                    'role' => 'artist'
                ]);
                $artist = $user->artist()->create([
                    'type' => 'C'
                ]);
                $songData['composer_id'] = $artist->id;
            }
        }else if(Auth::user()->artist->type == 'C'){
            $songData['composer_id'] = Auth::user()->artist->id;
            $user = User::where('first_name', $datas['author']['first_name'])
                        ->where('last_name', $datas['author']['last_name'])
                        ->first();
            if($user){
                $songData['author_id'] = $user->artist->id;
            }else{
                $user = User::create([
                    'first_name' => $datas['author']['first_name'], 
                    'last_name' => $datas['author']['last_name'],
                    'phone' => '+976 ',
                    'password' => '123456789',
                    'role' => 'artist'
                ]);
                $artist = $user->artist()->create([
                    'type' => 'A'
                ]);
                $songData['author_id'] = $artist->id;
            }
        }
        $songData['year'] = $datas['year'];
        $songData['lang'] = $datas['lang'];
        $songData['performer'] = $datas['performer'];
        $song = Song::create($songData);
        if($song){
            return response()->json([
                'status' => 'success',
                'result' => Auth::user()->artist->songs
            ]);
        }

        return response()->json([
            'status' => 'error',
            'result' => $song
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        $authorComposerIds = [$song->author_id, $song->composer_id];

        $artists = Artist::whereIn('id', $authorComposerIds)
            ->with('user')
            ->get();
        
        foreach ($artists as $artist) {
            if ($artist->id === $song->author_id) {
                $song['author']['first_name'] = $artist->user->last_name;
                $song['author']['last_name'] = $artist->user->first_name;
            }
        
            if ($artist->id === $song->composer_id) {
                $song['composer']['first_name'] = $artist->user->last_name;
                $song['composer']['last_name'] = $artist->user->first_name;
            }
        }
        
        return response()->json([
            'status' => 'success',
            'result' => $song
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSongRequest  $request
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSongRequest $request, Song $song)
    {
        try {
            $song->origin_name = $request->origin_name;
            $song->performer = $request->performer;
            $song->year = $request->year;
            $song->lang = $request->lang;
            $song->save();

            return response()->json([
                'status' => 'success',
                'result' => Auth::user()->artist->songs,
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status'=> 'error',
                'result' => $e
            ]);
        }
        


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        if($song->delete()){
            return response()->json([
                'status' => 'success',
                'result' => Auth::user()->artist->songs
            ]);
        }

        return response()->json([
            'status' => 'error',
            'result' => 'Delete error'
        ]);
    
    }
}
