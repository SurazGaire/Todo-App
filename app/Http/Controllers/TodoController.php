<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TodoController extends Controller
{
    public function index()
    {
        if(auth()->user()->is_admin){
            return redirect(route('users.index'));
        }

        return view('user.todos.index');
    }

    public function fetchtodos()
    {
        $todos = auth()->user()->is_admin ? Todo::all():auth()->user()->todos;
        return response()->json([
            'todos'=> $todos,
         ]);
    }

    // public function create(){
    //     return view('user.todos.create');{{  }}{{  }}{{  }}
    // }

    public function store(Request $request)
    {
        Todo::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=> Todo::STATUS['Todo'],
            'date'=>now(),
            'user_id' => auth()->id(),
        ]);

        // return redirect()->route('todos.index');
        return response()->json([
            'status'=>200,
            'message'=>"Todo Added Sucessfully",
        ]);

    }

    public function edit(Todo $todo)
    {
        $this->authorize('view',$todo);

        return view('user.todos.edit',compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update',$todo);

        $todo->update([
            'title' => $request->title,
            'description'=>$request->description,
            'status'=>$request->status,
            'completed_at' => $request->status == Todo::STATUS['Completed'] ? now() : null,
        ]);
        return redirect()->route('todos.index');

    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response(null);
    }
}
