<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;

use App\Http\Resources\SpecializationResource;
use Illuminate\Support\Facades\Validator;


class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $specializations = Specialization::all();
        return SpecializationResource::collection($specializations);
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
        $name         = $request['name'];
        $description  = $request['description'];
        $image = $request->file('image');
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
     
        $specialization = Specialization::create([
            'name' => $name,
            'image' => $imageName,
            'description' => $description,
        ]);
        return (new SpecializationResource($specialization))->response()->setStatusCode(201);
  
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialization $specialization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialization $specialization)
    {
        //
        $specialization->update($request->all());
        return new SpecializationResource($specialization);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialization $specialization)
    {
        //
        $specialization->delete();
        //return "deleted";
        return response("Deleted", 204);
    }
}
