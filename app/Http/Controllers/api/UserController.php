<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::all();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name"=>"unique:users|required|min:3",
            "email"=>['unique:users','required','email',function ($attribute, $value, $fail) {
                if (!str_contains($value, '.com')) {
                    $fail('The '.$attribute.' must include ".com".');
                }
            }],
            "phone"=>"unique:users|required",
            "password"=>"required|min:8"


        ]);
     
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $users=User::create($request->all());
        //dd($users);
         
        // $uploadedFile = $request->file('image')->store('public/apiDocs');
  

        // $user=new User();
        // $user->image=$request->file->hashName();
        // You can also generate a publicly accessible URL to the stored file
        // $url = Storage::url($uploadedFile);

        // Process the uploaded file or save its path in the database if needed

        

        
        //return ['uploadedFile' => $uploadedFile];



        // $validator = Validator::make($request->all(), [
        //     "name" => "unique:users|required|min:3",
        //     "email" => [
        //         'unique:users',
        //         'required',
        //         'email',
        //         function ($attribute, $value, $fail) {
        //             if (!str_contains($value, '.com')) {
        //                 $fail('The ' . $attribute . ' must include ".com".');
        //             }
        //         }
        //     ],
        //     "phone" => "unique:users|required",
        //     "password" => "unique:users|required|min:8",
        //     "image" => "required|image|mimes:jpeg,png,jpg,gif|max:2048", // Adjust validation rules as needed
        // ]);
    
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }
    
        // // Check if a file was uploaded
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $imageName);
    
        //     // Save the image information to the database
        //     $imageModel = new User();
        //     $imageModel->image = 'images/' . $imageName;
        //     $imageModel->save();
    
        //     $userData = $request->all();
        //     $userData['file_path'] = $imageModel->image;
    
        //     $user = User::create($userData);
    
        //     // Generate a publicly accessible URL to the stored file
        //     $url = asset($imageModel->image);
    
        //     return response()->json(['message' => 'User created and image uploaded successfully', 'url' => $url]);
        // } else {
        //     return response()->json(['error' => 'No image file provided'], 422);
        // }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
        $validator = Validator::make($request->all(), [
            "name"=>"required|min:3",
            "email"=>['required','email',function ($attribute, $value, $fail) {
                if (!str_contains($value, '.com')) {
                    $fail('The '.$attribute.' must include ".com".');
                }
            }],
            "phone"=>"required",
            "password"=>"required|min:8"
             

        ]);
     
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $user->update($request->all());
        
      
       //return new UserResource($users);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        
        $user->delete();
        //return "user deleted";
    }
}
