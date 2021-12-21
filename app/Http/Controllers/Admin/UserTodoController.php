<?php

namespace App\Http\Controllers\Admin;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTodoController extends Controller
{
    public function index(User $user){
        $todos = $user->todos()->orderBy('status','asc')->get()->groupBy('status');

        // foreach($todos as $status => $userTodos){
        //     // display status here $status
        //     foreach($userTodos as $todo){

        //     }
        // }

        return view('admin.users.todos.index',compact('todos'));
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response(null);
    }
}
