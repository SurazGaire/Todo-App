@extends('layouts.app');
@section('content');
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h3>Edit Todo</h3>
            <form method="POST" action="{{route('todos.update',$todo)}}">
                @csrf
                @method('patch')
                <div class="form-group">
                  <label">Title</label>
                  <input type="text" class="form-control" name="title" value="{{$todo->title}}" id="" placeholder="Some Title">
                </div>

                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Descreption</label>
                  <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">{{$todo->description}}
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Status</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="status">
                    @foreach (App\Models\Todo::STATUS as $status)
                    <option
                    @if ($todo->status == $status)
                        selected
                    @endif
                    >{{ $status }}</option>
                    @endforeach
                    </select>
                  </div>
                <button class="btn btn-primary" name="create_todo" style="margin-top:20px">Update</button>
              </form>


        </div>
    </div>
</div>

@endsection
