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


  {{-- EditModal --}}
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="Label">Update Todo</h5>
          <button type="button" class="close_modal close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="">
                @csrf
                @method('patch')
                <div class="form-group">
                  <label">Title</label>
                  <input type="text" class="form-control" name="title" value="" id="title" placeholder="Some Title">
                  <input type="hidden" id="edit_todo_id">
                </div>

                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Descreption</label>
                  <textarea class="form-control" name="description" id="description" rows="3">
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Status</label>
                    <select class="form-control" name="status" id="status">
                    {{-- @foreach (App\Models\Todo::STATUS as $status)
                    <option
                    @if ($todo->status == $status)
                        selected
                    @endif
                    >{{ $status }}</option>
                    @endforeach --}}

                    </select>
                  </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="close_modal btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_todo">Update</button>
        </div>
      </div>
    </div>
  </div>
  {{-- End EditModal --}}

@endsection

@push('scripts')
<script>
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
                            <a onclick="handleEdit(${item.id})" class="btn btn-transparent" ><i class="fa fa-pen"></i></a>
                            <a onclick="return confirm('Are you sure?') && handleDelete(${item.id})"  class="btn btn-transparent"><i class="fa fa-trash"></i></a>
                          </td>
                    </tr>`);
                    });
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

        $('.close_modal').click(function(){
            $('#editModal').modal('hide');

        });

        $('.update_todo').click(function(){
            var edit_id = $('#edit_todo_id').val();
            data = {
                'title' : $('#title').val(),
                'description' : $('#description').val(),
                'status' : $('#status').val(),
                '_token': '{{ csrf_token() }}',
            }
            $.ajax({
            url: "todos/" + edit_id,
            type: 'PATCH',
            data : data ,
            dataType : "json",
                success: function(response){
                // console.log(response);
                $('#success_message').html("");
                $('#success_message').addClass('alert alert-success');
                $('#success_message').text(response.message);
                $('#editModal').modal('hide');
                $('#exampleModal').find('input').val("");
                fetchtodos();
                }
            });

        });


    function handleDelete(id)
    {
        $.ajax({
        url: "todos/" + id,
        type: 'DELETE',
        data : { "_token": "{{ csrf_token() }}"},
            success: function(result){
            fetchtodos();
            alert('Todo deleted successfully');
            }
        });
    }

    function handleEdit(id)
    {

        console.log(id);
        $('#editModal').modal('show');

        $.ajax({
        url: `todos/${id}/edit`,
        type: 'GET',
            success: function(response){

                if (response) {
                    $('#status').html("");
                    $('#title').val(response.todo.title);
                    $('#description').val(response.todo.description);
                    let status = [
                        "Todo",
                        "Doing",
                        "Completed",
                        "Archived",
                    ];

                    $('#edit_todo_id').val(response.todo.id);
                    status.forEach(status => {
                        $('#status').append(`<option value="${status}" ${status == response.todo.status ? 'selected' : ''}>${status}</option>`);
                        return;
                    });

                }

            }
        });
    }
</script>

@endpush
