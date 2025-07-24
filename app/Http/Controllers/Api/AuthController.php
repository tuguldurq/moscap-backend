<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\StorePublisherRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Heir;
use App\Models\Artist;
use App\Models\UserBanks;
use App\Models\EmergencyContact;
use App\Models\ArtistManager;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArtistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function signupArtist(StoreArtistRequest $request){

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
            if(isset($artistData['heir'])){
                $heir = $user->heir()->create($artistData['heir'] ?? []);
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'User Created Successfully',
                'token' => $user->createToken(config('app.secret-key'))->plainTextToken
            ], 200);
            
        } catch (\Throwable $th) {
            error_log($th);
        }
        
    }

    public function signupPublisher(StorePublisherRequest $request){
        try {
            $data = $request->all();
            $userData = $data['user'];
            $publisherData = $data['company'];
            $user = User::create($userData);
            $publisher = $user->publisher()->create($publisherData);
            $publisherAccountant = $publisher->publisherAccountant()->create($publisherData['finance'] ?? []);
            return response()->json([
                'status' => 'success',
                'message' => 'User Created Successfully',
                'token' => $user->createToken(config('app.secret-key'))->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            error_log($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Server error',
            ], 500);
        }
        
    }
    public function login(Request $request){
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);
     
        $user = User::where('phone', $request->phone)->first();
     
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['error.logginFailed'],
            ]);
        }
     
        return $user->createToken(config('app.secret-key'))->plainTextToken;
    }

    public function me(Request $request) {
        return $request->user();
    }

    public function updatePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        if(!Hash::check($request->old_password, auth()->user()->password)){
            return response()->json(['error' => 'validation.oldPasswordMisMatch']);
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'validation.passwordChanged']);

    }

    public function forgetPassword(Request $request){
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status == Password::RESET_LINK_SENT
        ? response()->json(['message' => 'Password reset link sent.'], 200)
        : response()->json(['message' => 'Unable to send reset link.'], 422);

    }

    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );
    
        return $status == Password::PASSWORD_RESET
                    ? response()->json(['message' => 'Password reset successful.'], 200)
                    : response()->json(['message' => 'Unable to reset password'], 500);
    
    }
}
