<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Auth;

class TodoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $todo = Auth::user()->todo()->get();
        return response()->json(['status' => 'success','result' => $todo]);
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
        'description' => 'required',
        'category_id' => 'required',
         'status'=>'required'
         ]);
        if(Auth::user()->todo()->Create($request->all())){
            return response()->json(['status' => 'success']);
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
    public function show(Request $request)

    { 

       if($request->day!=null && $request->month==null)
        // return response()->json(["status1"=>$request->day]);
        $todo = Todo::whereDate('created_at', $request->day)->get();
        else if($request->month!=null || $request->day==null )
            $todo = Todo::whereMonth('created_at',$request->month)->get();
            //   return response()->json(["status2"=>$request->month]);
         else
              return response()->json(["status"=>"failed"],500);

        return response()->json($todo);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todo::where('id', $id)->get();
        return view('todo.edittodo',['todos' => $todo]);
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
        $this->validate($request, [
        'todo' => 'filled',
        'description' => 'filled',
        'category' => 'filled'
         ]);
        $todo = Todo::find($id);
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
        if(Todo::destroy($id)){
             return response()->json(['status' => 'success']);
        }
    }
}
