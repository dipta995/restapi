<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
//use Dotenv\Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users =  User::all();
        return response()->json([
            'success'=>true,
            'message'=> 'Display a listing of the resource.',
            'data'  => $users
        ]);
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
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
  
         
         $validator = Validator::make($request->all(), [
            'name' =>'required|string',
            'email' =>'required|email|unique:users',
            'password' =>'required|min:8',
          
         ]);
        
         if ($validator->fails()) {
           return response()->json([
               'success'=>false,
               'errors'=>$validator->errors()
            ],401);
         }
         try {
            //User::create($request->all());
              User::insert([

                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->email)
            ]);
            return response()->json([
                'success'=>true,
                'message'=> 'Record Added'
                 
            ]);
         } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'errors'=>'Something went wrong'
             ],400); 
         }
     
       
        
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        
      

        try {
            User::findOrFail($id);
            return response()->json([
                'success'=>true,
                'message'=> 'Display the specified resource.',
                'data'  => User::find($id)
                 
            ]);
        } catch (Exception $e) {
            
            return response()->json([
                'success'=>false,
                'message'=> 'No Data Found'
                 
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         
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
        $validator = Validator::make($request->all(), [
            'name' =>'required|string',
            'email' =>'required|email|unique:users',
            'password' =>'required|min:8',
          
         ]);
        
         if ($validator->fails()) {
           return response()->json([
               'success'=>false,
               'errors'=>$validator->errors()
            ],401);
         }
         try {
            
            $user = User::FindOrFail($id);
                $user->name=$request->name;
                $user->email=$request->email;
                $user->password=Hash::make($request->email);
                $user->save();
           
            return response()->json([
                'success'=>true,
                'message'=> 'Record Updated',
                'data'=>$user
                 
            ]);
         } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'errors'=>'Something went wrong'
             ],400); 
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        
        try {
            User::findOrFail($id)->delete();
            return response()->json([
                'success'=>true,
                'message'=> 'User Remove Successfully'
                 
            ]);
        } catch (Exception $e) {
            
            return response()->json([
                'success'=>false,
                'message'=> 'Opps Something wrong'
                 
            ]);
        }
    }
}
