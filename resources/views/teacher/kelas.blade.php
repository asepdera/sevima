@extends('layout.layout_teacher')

@section('title','Class')
@section('name',auth()->user()->name)
@section('role',auth()->user()->role)

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Class</div>
                <button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#inlineForm">Add Class</button>
            </div>
            <div class="card-body">
                <div class="overflow-x-scroll" style="overflow-y: hidden !important;">
                    <table class="table table-striped">
                        <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th>Class Code</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @if (count($kelas) == 0)
                                <tr>
                                    <td colspan="4">No Data</td>
                                </tr>
                            @else
                                @foreach ($kelas as $st)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <span>{{$st->name}}</span>
                                        </td>
                                        <td>{{$st->class_code}}</td>
                                        <td>
                                            <button class="btn btn-primary" onclick="edit({{$st->id}})" >Edit</button>
                                            <form action="{{url('/teacher/kelas/delete/'.$st->id)}}" method="post" class="d-inline">
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
                <h4 class="modal-title" id="myModalLabel33">Add Class</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{url('/teacher/kelas/add')}}" method="POST">
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
                <h4 class="modal-title" id="myModalLabel33">Edit Class</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{url('/teacher/kelas/update/')}}" method="POST">
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
                url: `{{url('/teacher/kelas/edit')}}/${id}`,
                type: "GET",
                success: function(data){
                    $('#edit').modal('show');
                    $('#edit #name').val(data.kelas.name);
                    $('#edit #id').val(data.kelas.id);
                }
            });
        }
    </script>
@endsection