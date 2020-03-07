<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category;
use Auth;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category =Category::all();
        return response()->json(['status' => 'success','result' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'name' => 'required',
         ]);
       
        if($cat=Category::Create($request->all())){
            return response()->json(['status' => 'success','category'=>$cat]);
        }else{
            return response()->json(['status' => 'fail']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
        'name' => 'filled',
         ]);
        $category = Category::find($id);
        if($todo->fill($request->all())->save()){
           return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'failed']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Category::destroy($id)){
             return response()->json(['status' => 'success']);
        }
    }
}
