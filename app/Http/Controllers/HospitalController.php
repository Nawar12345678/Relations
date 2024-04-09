<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use App\Http\Requests\HospitalRequest;
use App\Http\Requests\UpdateRequest;
use DB;


class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospitals= Hospital::all();
        return response()->json([
            'status' => 'success',
            'hospitals' => $hospitals,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HospitalRequest $request)
    {
        
        try{
            DB::beginTransaction();
        $hospital = Hospital::create([
            'name' => $request->name,
            'specialest' => $request->specialest,
            'location' => $request->location,
        ]);
        DB::commit();
        $hospital->doctores()->attach($request->doctor_id);
        return response()->json([
            'status' => 'success',
            'hospital' => $hospital
        ]);
    }
    catch(\Throwable $th){
        DB::rollBack();
        log::error($th);
        return response()->json([
            'status' => 'error',
        ], 500);

    }

    }
    

    /**
     * Display the specified resource.
     */
    public function show(Hospital $hospital)
    {
        return response()->json([
            'status' => 'success',
            'hospital' => $hospital
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Hospital $hospital)
    {
    try{
        DB:beginTransaction();
        $newData = [];
        if(isset($request->name)){
            $newData['name']=$request->name;
        }
        if(isset($request->specialest)){
            $newData['specialest']=$request->specialest;
        }
        if(isset($request->location)){
            $newData['location']=$request->location;
        }
        DB::commit();
        $hospital->update($newData);
        return response()->json([
            'status' => 'success',
            'hospital' => $hospital
        ]);
    }
    catch(\Throwable $th){
        DB::rollBack();

        log::error($th);
        return response()->json([
            'status' => 'error',
        ], 500);

    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hospital $hospital)
    {
        $hospital->delete();
        return response()->json([
            'status' => 'success',
        ]);

    }
}
