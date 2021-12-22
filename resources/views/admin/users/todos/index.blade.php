@extends('layouts.app');

@section('content');
<div class="container">
    <div class="row justify-content-center">
        @foreach ($todos as $status => $userTodos)
        <h3 class="text-center text-muted">{{ $status }}</h3>
            <div class="col-md-10">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                        <tbody>
                            @foreach ($userTodos as $todo)
                                <tr>
                                    <td>{{ $todo->id }}</td>
                                    <td>{{ $todo->title }}</td>
                                    <td>{{ $todo->description }}</td>
                                    <td>{{ $todo->status }}</td>
                                    <td>{{ $todo->date }}</td>
                                    <td>
                                        <button onclick="return confirm('Are you sure?') && handleDelete({{$todo->id}})" class="btn btn-transparent">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        @endforeach
    </div>
</div>
@endsection
@push('scripts')
<script>
        function handleDelete(todoId)
        {
            $.ajax({
            url: `/user/todos/${todoId}/delete`,
            method: 'DELETE',
            data : { "_token": "{{ csrf_token() }}"},
                success: function(result){
                    alert('Todo deleted successfully');
                }
            });
        }
</script>

@endpush
