<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHeirRequest;
use App\Models\Heir;


class HeirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!empty(auth()->user()->heir)){
            return response()->json(['data' => auth()->user()->heir]);
        }
        return response()->json(['data' => null]);
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
     * @param  \App\Http\Requests\StoreHeirRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHeirRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        // $data['phone'] = $data['phone']['prefix']." ".$data['phone']['number'];
        // $data['register_number'] = $data['register_number']['letter1'].$data['register_number']['letter1'].$data['register_number']['number'];
        $data['file_path'] = $data['file_path']['file']['response'];
        $data['type'] = $data['type']['id'];
        $heir = Heir::create($data);
        $heir->load('type');

        return response()->json($heir);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Heir  $heir
     * @return \Illuminate\Http\Response
     */
    public function show(Heir $heir)
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
     * @param  \App\Http\Requests\StoreHeirRequest  $request
     * @param  \App\Models\Heir $heir
     * @return \Illuminate\Http\Response
     */
    public function update(StoreHeirRequest $request, Heir $heir)
    {
        $data = $request->all();
        $data['type'] = $data['type']['id'];
        $heir->update($data);
        $heir->load('type');
        return response()->json($heir);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Heir $heir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Heir $heir)
    {
        // $manager->delete();
        // auth()->user()->load("managers");
        // return response()->json(auth()->user()->managers);
    }
}
