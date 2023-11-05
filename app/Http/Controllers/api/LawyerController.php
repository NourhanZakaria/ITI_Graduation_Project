<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\User;
use App\Models\City;
use App\Models\Specialization;
use App\Models\lawyerSpecialization;

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
        $lawyers = Lawyer::whereHas('specialization', function ($query) {
        })

            ->whereHas('user', function ($query) {
            })
            ->with('user')
            ->whereHas('user.city', function ($query) {
            })
            ->with('user.city')
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
         //  $specialization->push(['name'=>$request['specialization']]);
      
    
        //$user   = User::create($data_user);
        */
      
        $data_lawyer = [
            'price'    => $request['price'],
            'span'     => $request['span'],
            'location' => $request['location'],
            'about'    => $request['about'],
            'user_id' => $request['user_id'],
        ];
      
        $specialization_id = $request->input('specialization_id');
        $lawyer = Lawyer::create($data_lawyer);
        $lawyer_specialization = lawyerSpecialization::create(['lawyer_id'=>$lawyer->id,'specialization_id'=>$specialization_id]);

        return (new LawyerResource($lawyer))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lawyer $lawyer)
    {
        //
        $id = $lawyer->id;
        $lawyer = Lawyer::whereHas('specialization', function ($query) {
             })
            ->with('specialization')
            ->whereHas('user', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->with('user')
            ->whereHas('user.city', function ($query) {
            })
            ->with('user.city')
            ->get();
        /*
        $lawyer = Lawyer::join('users','users.id','lawyers.user_id')
                        ->join('cities','cities.id','users.city_id')
                        ->join('countries','countries.id','cities.country_id')
                        ->select('lawyers.*','users.name as username','users.email','users.image','users.phone','users.role','cities.name as city_name','countries.name as country_name')
                        ->where('lawyers.id',$lawyer->id)
                        ->get();
*/
        return new LawyerResource($lawyer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        //
    
         $lawyer->update($request->all());
         return new LawyerResource($lawyer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lawyer $lawyer)
    {
        //
        $lawyer->delete();
        //return "deleted";
        return response("Deleted", 204);
    }

    public function search(Request $request)
    {


        $specialization = $request->input('specialization');
        $city = $request->input('city');
        $name_lawyer = $request->input('name_lawyer');

        if ($specialization != null && $city != null && $name_lawyer != null) {
            $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
                $query->where('name', $specialization);
            })
                ->whereHas('user', function ($query) use ($name_lawyer) {
                    $query->where('name', 'LIKE', "%{$name_lawyer}%");
                })
                ->with('user')
                ->whereHas('user.city', function ($query) use ($city) {
                    $query->where('name', $city);
                })
                ->with('user.city')
                ->get();
        } elseif ($specialization != null && $city == null && $name_lawyer == null) {
            $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
                $query->where('name', $specialization);
            })
                //  ->with('specialization')
                ->whereHas('user', function ($query) {
                })
                ->with('user')
                ->whereHas('user.city', function ($query) {
                })
                ->with('user.city')
                ->get();
        } elseif ($specialization == null && $city != null && $name_lawyer == null) {
            $lawyers = Lawyer::whereHas('user.city', function ($query) use ($city) {
                $query->where('name', $city);
            })
                ->with('user.city')
                ->get();
        } elseif ($specialization == null && $city == null && $name_lawyer != null) {

            $lawyers = Lawyer::whereHas('user', function ($query) use ($name_lawyer) {
                $query->where('name', 'LIKE', "%{$name_lawyer}%");
            })
                ->with('user')
                ->whereHas('user.city', function ($query) {
                })
                ->with('user.city')
                ->get();
        } elseif ($specialization == null && $city != null && $name_lawyer != null) {

            $lawyers = Lawyer::whereHas('specialization', function ($query) {
            })

                ->whereHas('user', function ($query) use ($name_lawyer) {
                    $query->where('name', 'LIKE', "%{$name_lawyer}%");
                })
                ->with('user')
                ->whereHas('user.city', function ($query) use ($city) {
                    $query->where('name', $city);
                })
                ->with('user.city')
                ->get();
        } elseif ($specialization != null && $city == null && $name_lawyer != null) {
            $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
                $query->where('name', $specialization);
            })
                ->whereHas('user', function ($query) use ($name_lawyer) {
                    $query->where('name', 'LIKE', "%{$name_lawyer}%");
                })
                ->with('user')
                ->whereHas('user.city', function ($query) {
                })
                ->with('user.city')
                ->get();
        } elseif ($specialization != null && $city != null && $name_lawyer == null) {
            $lawyers = Lawyer::whereHas('specialization', function ($query) use ($specialization) {
                $query->where('name', $specialization);
            })
                ->whereHas('user', function ($query) {
                })
                ->with('user')
                ->whereHas('user.city', function ($query) use ($city) {
                    $query->where('name', $city);
                })
                ->with('user.city')
                ->get();
        } else {
            $lawyers = Lawyer::whereHas('specialization', function ($query) {
            })
    
                ->whereHas('user', function ($query) {
                })
                ->with('user')
                ->whereHas('user.city', function ($query) {
                })
                ->with('user.city')
                ->get();
        }

        // dd($lawyers);
        return LawyerResource::collection($lawyers);
    }
}
