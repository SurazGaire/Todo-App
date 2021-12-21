@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

                @if (!auth()->user()->is_admin)
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
                    Create Todo
                  </button>
                @endif
                <div id="success_message"></div>
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Completed At</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                 {{-- @foreach ($todos as $todo)

                @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Label">Create Todo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST"  id="#create_todoForm">
                @csrf
                <div class="form-group">
                  <label">Title</label>
                  <input type="text" class="form-control title" name="title" id="" placeholder="Some Title">
                </div>

                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Descreption</label>
                  <textarea class="form-control description" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_todo">Create</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        fetchtodos();
        function fetchtodos() {
            $.ajax({
                type:'GET',
                url:'/fetchtodos',
                dataType :'json',
                success:function(response){
                    // console.log(response.todos);
                    $('tbody').html("");
                    $.each(response.todos,function(key,item){
                        $('tbody').append(`<tr>
                          <td>${item.id}</td>
                          <td>${item.title}</td>
                          <td>${item.description}</td>
                          <td>${item.status}</td>
                          <td>${item.date}</td>
                          <td>${item.completed_at ?? 'Not Completed'}</td>
                          <td>
                            <a href="todos/${item.id}/edit" class="edit_todo btn btn-transparent" ><i class="fa fa-pen"></i></a>
                            <a onclick="return confirm('Are you sure?') && handleDelete(${item.id})"  class="btn btn-transparent"><i class="fa fa-trash"></i></a>
                          </td>
                    </tr>`);
                    });
                }

            });

        }
        function handleDelete(id)
        {
            console.log('scas');
            $.ajax({
            url: "/todos/" + id,
            type: 'DELETE',
            data : { "_token": "{{ csrf_token() }}"},
                success: function(result){
                alert('Todo deleted successfully');
                }
            });
        }

        $('.add_todo').click(function(){
            console.log("hello");
            data = {
                'title' : $('.title').val(),
                'description' : $('.description').val(),
                '_token': '{{ csrf_token() }}',
            }
            $.ajax({
            url: "/todos",
            type: 'POST',
            data : data ,
                success: function(response){
                // console.log(response);
                $('#success_message').addClass('alert alert-success');
                $('#success_message').text(response.message);
                $('#exampleModal').modal('hide');
                $('#exampleModal').find('input').val("");
                fetchtodos();
                }
            });

        });

        $('.edit_todo').click(function(e){
            e.preventDefault();
            console.log("hello");
            // data = {
            //     'title' : $('.title').val(),
            //     'description' : $('.description').val(),
            //     '_token': '{{ csrf_token() }}',
            // }
            // $.ajax({
            // url: "/todos",
            // type: 'POST',
            // data : data ,
            //     success: function(response){
            //     // console.log(response);
            //     $('#success_message').addClass('alert alert-success');
            //     $('#success_message').text(response.message);
            //     $('#exampleModal').modal('hide');
            //     $('#exampleModal').find('input').val("");
            //     fetchtodos();
            //     }
            // });

        })
    });
</script>

@endpush
