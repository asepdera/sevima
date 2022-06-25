@extends('layout.layout_teacher')

@section('title','Subject')
@section('name',auth()->user()->name)
@section('role',auth()->user()->role)

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Subject</div>
                <button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#inlineForm">Add Subject</button>
            </div>
            <div class="card-body">
                <div class="overflow-x-scroll" style="overflow-y: hidden !important;">
                    <table class="table table-striped">
                        <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @if (count($subject) == 0)
                                <tr>
                                    <td colspan="4">No Data</td>
                                </tr>
                            @else
                                @foreach ($subject as $st)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <span>{{$st->name}}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" onclick="edit({{$st->id}})" >Edit</button>
                                            <form action="{{url('/teacher/subject/delete/'.$st->id)}}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <div
          class="modal fade text-start"
          id="inlineForm"
          tabindex="-1"
          aria-labelledby="myModalLabel33"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Add subject</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{url('/teacher/subject/add')}}" method="POST">
                @csrf
                <div class="modal-body">
                  <label>Name: </label>
                  <div class="mb-1">
                    <input type="text" placeholder="Class Name" class="form-control" name="name" />
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" class="btn btn-primary" data-bs-dismiss="modal" value="Add">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div
          class="modal fade text-start"
          id="edit"
          tabindex="-1"
          aria-labelledby="myModalLabel33"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Edit Subject</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{url('/teacher/subject/update/')}}" method="POST">
                @csrf
                <div class="modal-body">
                  <label>Name: </label>
                  <input type="hidden" name="id" id="id">
                  <div class="mb-1">
                    <input type="text" placeholder="Class Name" class="form-control" name="name" id="name" />
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" class="btn btn-primary" data-bs-dismiss="modal" value="Update">
                </div>
              </form>
            </div>
          </div>
        </div>
@endsection
@section('script')
    <script>
        function edit(id){
            $.ajax({
                url: `{{url('/teacher/subject/edit')}}/${id}`,
                type: "GET",
                success: function(data){
                    $('#edit').modal('show');
                    $('#edit #name').val(data.subject.name)
                }
            });
        }
    </script>
@endsection