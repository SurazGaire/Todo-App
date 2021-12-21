@extends('layouts.app');
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3>Create Todo</h3>
            <form method="POST" action="{{route('todos.store')}}" >
                @csrf
                <div class="form-group">
                  <label">Title</label>
                  <input type="text" class="form-control" name="title" id="" placeholder="Some Title">
                </div>

                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Descreption</label>
                  <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <button class="btn btn-primary" name="create_todo" style="margin-top:20px">Create</button>
              </form>


        </div>
    </div>
</div>
@endsection
