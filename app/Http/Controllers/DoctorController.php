<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Requests\DoctorUpdateRequest;
use App\Http\Requests\DoctorRequest;
use Illuminate\Support\Facades\Log;
use DB;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors= Doctor::all();
        return response()->json([
            'status' => 'success',
            'doctors' => $doctors,
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $request)
    {

        try{
            DB::beginTransaction();
        $doctor = Doctor::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'specialest' => $request->specialest,
        
        ]);
        DB::commit();
        $doctor->hospitals()->attach($request->hospital_id);
        return response()->json([
            'status' => 'success',
            'doctor' => $doctor
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
    public function show(Doctor $doctor)
    {
        return response()->json([
            'status' => 'success',
            'doctor' => $doctor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorUpdateRequest $request, Doctor $doctor)
    {
        try{
            DB::beginTransaction();
            $newData = [];
            if(isset($request->first_name)){
                $newData['first_name']=$request->first_name;
            }
            if(isset($request->last_name)){
                $newData['last_name']=$request->last_name;
            }
            if(isset($request->specialest)){
                $newData['specialest']=$request->specialest;
            }
            DB::commit();
            $doctor->update($newData);
            return response()->json([
                'status' => 'success',
                'doctor' => $doctor
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
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }
}
