<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\User;
use App\Models\City;
use App\Models\Specialization;

use Illuminate\Http\Request;
use App\Http\Resources\LawyerResource;
use Illuminate\Support\Facades\Validator;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $lawyers = Lawyer::join('users','users.id','lawyers.user_id')
                           ->join('cities','cities.id','users.city_id')
                           ->join('countries','countries.id','cities.country_id')
                           ->select('lawyers.*','users.name as username','users.email','users.image','users.phone','users.role','cities.name as city_name','countries.name as country_name')
                           ->get();

       // dd($lawyers);
       return LawyerResource::collection($lawyers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        //Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',  
        ]);
        if($validator->fails())
        {
            return response($validator->errors()->all(), 422);
        }
        $ImageName = $request->file('ImagePath')->getClientOriginalName();
        $request->file('ImagePath')->move(public_path('images/lawyer/'),$ImageName);
        //Create Data
        $data_user = [
            'name' => $request['name'],
            'email' => $request['email'],
            'image' => 'images/universities/'.$ImageName,
            'phone' => $request['phone'],
            'role' => $request['role'],
            'password' => $request['password'],
            'city_id ' => $request['city_id '],
        ];
        */
        $data_lawyer = [
            'price' => $request['price'],
            'span' => $request['span'],
            'user_id ' => $request['user_id'],
        ];
    
        //$user   = User::create($data_user);
        $lawyer = Lawyer::create($data_lawyer);

        return (new LawyerResource($lawyer))->response()->setStatusCode(201);
         
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Lawyer $lawyer)
    {
        //

        $lawyer = Lawyer::join('users','users.id','lawyers.user_id')
                        ->join('cities','cities.id','users.city_id')
                        ->join('countries','countries.id','cities.country_id')
                        ->select('lawyers.*','users.name as username','users.email','users.image','users.phone','users.role','cities.name as city_name','countries.name as country_name')
                        ->where('lawyers.id',$lawyer->id)
                        ->get();
        return new LawyerResource($lawyer);

        
     
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lawyer $lawyer)
    {
        //
    }

    public function search(Request $request)
    {
     
                
        $specialization = $request->input('specialization');
        $city = $request->input('city');

        if($specialization !=null && $city !=null)
        {
                $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
                           $query->where('name', $specialization);
                        })
                        ->whereHas('user.city', function ($query) use ($city) {
                            $query->where('name', $city);
                        })
                        ->with('user.city')
                        ->whereHas('user.city.country', function ($query) {})
                        ->with('user.city.country')
                        ->get();
        }
        elseif($specialization != null && $city == null)
        {
                $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
                            $query->where('name', $specialization);
                        })
                      //  ->with('specialization')
                        ->whereHas('user', function ($query) {})
                        ->with('user')
                        ->whereHas('user.city', function ($query) {})
                        ->with('user.city')
                        ->whereHas('user.city.country', function ($query) {})
                        ->with('user.city.country')
                        ->get();
        }
        else
        {
                $lawyers = Lawyer::whereHas('user.city', function ($query) use ($city) {
                            $query->where('name', $city);
                        })
                        ->with('user.city')
                        ->whereHas('user.city.country', function ($query) {})
                        ->with('user.city.country')
                        ->get();
        }
        
        // dd($lawyers);
        return LawyerResource::collection($lawyers);
    } 
}
