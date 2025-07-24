<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Support\Facades\DB;

class EmergencyContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->emergency;
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
        $data['phone'] = $data['phone']['prefix']." ".$data['phone']['number'];
        $data['type_id'] = $data['type']['id'];
        auth()->user()->emergency()->create($data);
        auth()->user()->load("emergency");
        return response()->json(auth()->user()->emergency);
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
        $data = $request->all();
        $contact = EmergencyContact::find($id);
        $contact->name = $data["name"];
        $contact->type_id = $data['type']['id'];
        $contact->phone = $data["phone"]["prefix"]." ".$data["phone"]["number"];
        $contact->save();
        $contact->load('type');
        return response()->json($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EmergencyContact::destroy($id);
        auth()->user()->load('emergency');
        return response()->json(auth()->user()->emergency);
    }
}
