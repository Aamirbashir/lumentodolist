<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Users;
class UsersController extends Controller
{
   public function __construct() 
    {
      //  $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function register(Request $request)
  {
     $this->validate($request, [
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'password'=>'required'
         ]);
     $user= new Users();
     $user->firstname=$request->firstname;
     $user->lastname=$request->lastname;
    $user->email=$request->email;
    $user->password=Hash::make($request->password);
    $user->mobilenumber=$request->mobilenumber;
    $user->gender=$request->gender;
    $user->birthday=$request->birthday;
    if($user->save())
    {
           $apikey = base64_encode(str_random(40));
           Users::where('email', $request->email)->update(['api_key' => "$apikey"]);;
           return response()->json(['status' => 'success','api_key' => $apikey]);
    }
    else
    {
       return response()->json(['status' => 'fail'],500);
    }
  }
    public function authenticate(Request $request)
    {
        $this->validate($request, [
        'email' => 'required',
        'password' => 'required'
         ]);
       $user = Users::where('email', $request->input('email'))->first();
      if(Hash::check($request->input('password'), $user->password)){
           $apikey = base64_encode(str_random(40));
           Users::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;
           return response()->json(['status' => 'success','api_key' => $apikey]);
       }else{
           return response()->json(['status' => 'fail'],401);
       }
    }
}    
?>