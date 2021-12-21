@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created At</th>
                    <th scope="col">View Todos</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{ $user->email}}</td>
                    <td>{{$user->created_at}}</td>
                    <td><a href="{{ route('users.todos.index',$user->id) }}" class="btn btn-primary btn-sm">View Todos</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


