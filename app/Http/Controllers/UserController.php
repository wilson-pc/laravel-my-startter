<?php

namespace App\Http\Controllers;
use JWTAuth;
use Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Log;
class UserController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  auth()->user()->authorizeRoles(['user','admin']);
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       
        
        $validator= Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email',
                'password'=>'required',
                'role'=>'required',
            ]);
            $request->merge([
                'password' => bcrypt($request->password)
            ]);
          
            if ($validator->fails()) {
               return $validator->messages();
                }
           $user= User::create($request->all());
           $user->roles()->attach(Role::where('name', $request->role)->first());
         
           return $user;

            //code...
       
    }

    public function login(Request $request)
    {
        //
    
            
        $validator= Validator::make($request->all(),[
                'email' => 'required|email',
                'password'=>'required'
            ]);

            if ($validator->fails()) {
                return $validator->messages();
                 }
            $user = User::whereEmail($request->email)->first();
            $token = $user->createToken('blog')->accessToken;

        
            
            if (Hash::check($request->password, $user->password)) {
               
                return response()->json([
                    'data' => $user,
                    'token' => $token,
                ],200);
            }else{
                return response()->json([
                    'message' => "usuario o contraseña incorrecta",
                ],404);
            }
           
           
            //code...
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
