<?php

namespace App\Http\Controllers;

use App\Models\Specfication;
use Illuminate\Http\Request;
use App\Http\Requests\SpcficationRequest;
use DB;

class SpecficationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specfications = Specfication::with('doctors')->get();
        return response()->json([
            'status' => 'success',
            'specfications' => $specfications,
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpcficationRequest $request)
    {
        try{
            DB::beginTransaction();
        $specfication = Specfication::create([
            'name' => $request->name,
            'status' => $request->status,
        
        ]);
        DB::commit();
        return response()->json([
            'status' => 'success',
            'specfication' => $specfication
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
    public function show(Specfication $specfication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specfication $specfication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specfication $specfication)
    {
        //
    }
}
