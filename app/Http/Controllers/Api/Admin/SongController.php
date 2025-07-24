<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\User;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        return response()->json([
            'status' => 'success',
            'result' => Song::where('origin_name', 'like', "%{$search}%")->with(['author.user', 'composer.user'])->paginate($perPage),
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $song = new Song;
        $song->song_code = $data['song_code'];
        $song->origin_name = $data['origin_name'];
        $song->english_name = $data['english_name'];
        $song->year = $data['year'];
        $song->performer = $data['performer'];
        $song->composer_id = $data['composer_id'];
        $song->author_id = $data['author_id'];
        $saved = $song->save();
        if(!$saved){
            return response()->json(array('status' => 'error', 'result' => 'Error'));
        }
        return response()->json(array('status' => 'success'));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $song = Song::find($id);
        $data = $request->all();
        if($song){
            $song->origin_name = $data['origin_name']; 
            $song->english_name = $data['english_name']; 
            $song->performer = $data['performer']; 
            $song->song_code = $data['song_code']; 
            $song->year = $data['year'];
            if(isset($data['composer_id'])){
                $user = User::find($data['composer_id']); 
                $song->composer_id = $user->artist->id;
            }
            if(isset($data['author_id'])){
                $user = User::find($data['author_id']); 
                $song->author_id = $user->artist->id;
            }
            $song->save();
        }
        return response()->json(array('status' => 'success', 'result' => $song));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
