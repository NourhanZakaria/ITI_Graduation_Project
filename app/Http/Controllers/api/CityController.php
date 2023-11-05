<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Resources\CityResource;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cities = City::all();
        return CityResource::collection($cities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         //Validation
         $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',  
        ]);
        if($validator->fails())
        {
            return response($validator->errors()->all(), 422);
        }
     
        $city = City::create($request->all());
        return (new CityResource($city))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
        $city->update($request->all());
        return new CityResource($city);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
        $city->delete();
        //return "deleted";
        return response("Deleted", 204);
    }
}
