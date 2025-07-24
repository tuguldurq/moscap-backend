<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Models\User;
use App\Models\Artist;
use App\Http\Resources\ArtistResource;

class ArtistController extends Controller
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
        $Artists = Artist::where('stage_name', 'like', "%{$search}%")
            ->orWhereNull('stage_name')
            ->whereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")->orWhere('phone', 'like', "%{$search}%");
            
        })->paginate($perPage);
        return ArtistResource::collection($Artists);

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
     * @param  \Illuminate\Http\StoreArtistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtistRequest $request)
    {
        try {
            $data = $request->all();
            $userData = $data['user'];
            $artistData = $data['artist'];

            $user = User::create($userData);
            $bank = $user->bank()->create($userData['bank']);
            $emergency = $user->emergency()->createMany($userData['emergency'] ?? []);
            $artist = $user->artist()->create($artistData);
            $manager = $artist->managers()->createMany($artistData['manager'] ?? []);
            // user 
            if($artistData['heir'] && isset($artistData['heir'])){
                $heir = $user->heir()->create($artistData['heir'] ?? []);
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'User Created Successfully',
                'data' => $user
            ], 200);
            
        } catch (\Throwable $th) {
            error_log($th);
        }
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
     * @param  \Illuminate\Http\UpdateArtistRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArtistRequest $request, $id)
    {
        try {
            $data = $request->all();
            $artist = Artist::findOrFail($id);
            $artist->update($data['artist']);
            $user = $artist->user;
            $user->update($data['user']);            
            $user->bank()->update($data['user']['bank']);

            return response()->json([
                'status' => 'success',
                'message' => 'User updated Successfully',
                'result' => $user,
            ], 200);
        }catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
                return $errorMessage;        
        }
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
