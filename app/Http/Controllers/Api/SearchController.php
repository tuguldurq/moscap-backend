<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Song;
use App\Http\Resources\RepertoryResource;

class SearchController extends Controller
{
    public function all(){
        $data = Song::orderBy('origin_name')->with(['author.user', 'composer.user'])->paginate(10);
        return response()->json([
            'status' => 'success',
            'result' => $data
        ]);
    }

    public function repertory(Request $request){
       try {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('query');
            $type = $request->input('type', 1);
            if($type == 2){
                $data = Song::orWhereHas('composer.user', function ($query) use ($search) {
                    $query->where('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%");
                })->orWhereHas('author.user', function ($query) use ($search){
                    $query->where('last_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%");
                })->with(['author.user', 'composer.user'])->paginate($perPage);
            }else{
                $data = Song::where('origin_name', 'like', "%{$search}%")
                ->with(['author.user', 'composer.user'])->paginate($perPage);
            }
            return response()->json([
                'status' => 'success',
                'result' => $data
            ]);
       } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'result' => $th->getMessage(),
            ]);
       }
    }
}
