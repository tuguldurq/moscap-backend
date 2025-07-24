<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Http\Resources\ArtistResource;
use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\ArtistManager;
use App\Models\User;
use App\Models\Heir;
use App\Models\EmergencyContact;
use App\Models\UserBanks;

class ArtistsController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArtistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtistRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::create($data['user']);

            return response()->json([
                'status' => 'success',
                'message' => 'User Created Successfully',
                'result' => $user,
            ], 200);
        }catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
                return $errorMessage;        
        }
        // $newUser = $request->user;
        // $newAffiliation = $request->affiliation;
        // try {
        //     $register = $newUser['register'];
        //     $registerNumber = $register['letter1'].$register['letter2'].$register['number'];
        //     $phone = $newUser['phone']['prefix'].$newUser['phone']['number'];

        //     $user = User::create([
        //         'first_name' => $newUser['first_name'],
        //         'last_name' => $newUser['last_name'],
        //         'email' => $newUser['email'],
        //         'citizen' => $newUser['citizen'],
        //         'sex' => $newUser['sex'],
        //         'phone' => $phone,
        //         'facebook' => isset($newUser['facebook']) ? $newUser['facebook'] : null,
        //         'instagram' => isset($newUser['instagram']) ? $newUser['instagram'] : null,
        //         'register_number' => $registerNumber,
        //         'password' => $newUser['password'],
        //         'role' => 'Artist'
        //     ]);
        //     foreach ($newUser['emergency-list'] ?? [] as $key => $value) {
        //         $emergency = new EmergencyContact();
        //         $emergency->name = $value['name'] ?? null;
        //         $emergency->type = $value['type'] ?? null;
        //         $emergency->user_id = $user->id;
        //         $emergency->save();
        //     }
        //     $bank = new UserBanks();
        //     $bank->user_id = $user->id;
        //     $bank->name = $newUser['bank']['name'];
        //     $bank->account = $newUser['bank']['account'];
        //     $bank->save();

        //     if($newAffiliation['heir']){
        //         $heir = new Heir();
        //         $heir->user_id = $user->id;
        //         $heir->first_name = $newAffiliation['heir']['first_name'] ?? null;
        //         $heir->last_name = $newAffiliation['heir']['last_name'] ?? null;
        //         $heir->type = $newAffiliation['heir']['type'] ?? null;
        //         $heir->register_number = $newAffiliation['heir']['register_number'] ?? null;
        //         $heir->phone = $newAffiliation['heir']['phone'] ?? null;
        //         $heir->email = $newAffiliation['heir']['email'] ?? null;
        //         $heir->file_path = $newAffiliation['heir']['file_path'] ?? null;
        //         $heir->save();
        //     }
        //     $affiliation = Artist::create([
        //         'band_name' => $newAffiliation['band_name'] ?? null,
        //         'stage_name' => $newAffiliation['stage_name'] ?? null,
        //         'type' => $newAffiliation['type'] ?? [],
        //         'release_type' => $newAffiliation['release_type'],
        //         'user_id' => $user['id'],
        //     ]);

        //     foreach ($newAffiliation['manager-list'] ?? [] as $key => $value) {
        //         $manager = new ArtistManager();
        //         $manager->Artist_id = $affiliation->id;
        //         $manager->name = $value['name'] ?? null;
        //         $manager->phone = $value['phone'] ?? null;
        //         $manager->save();
        //     }
            
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'User Created Successfully',
        //     ], 200);
            
        // } catch (\Throwable $th) {
        //     $errorMessage = $th->getMessage();
        //     return $errorMessage;
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artist  $Artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $Artist)
    {
        return $Artist;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArtistRequest  $request
     * @param  \App\Models\Artist  $Artist
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArtistRequest $request, Artist $Artist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artist  $Artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $Artist)
    {
        //
    }
}
