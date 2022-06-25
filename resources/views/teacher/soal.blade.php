@extends('layout.layout_teacher')

@section('title','Assignment')
@section('name',auth()->user()->name)
@section('role',auth()->user()->role)
@section('css')
<link rel="stylesheet" type="text/css" href={{asset("app-assets/vendors/css/file-uploaders/dropzone.min.css")}}>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Assingment</div>
                <button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#inlineForm">Add Assignment</button>
            </div>
            <div class="card-body">
                <div class="overflow-x-scroll" style="overflow-y: hidden !important;">
                    <table class="table table-striped">
                        <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Class</th>
                            <th>Created In</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @if (count($soal) == 0)
                                <tr>
                                    <td colspan="4">No Data</td>
                                </tr>
                            @else
                                @foreach ($soal as $st)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <span>{{$st->name}}</span>
                                        </td>
                                        <td>
                                            @if($st->status == 'closed')
                                                <span class="badge bg-danger">{{$st->status}}</span>
                                            @else
                                                <span class="badge bg-success">{{$st->status}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span>{{$st->class_name}}</span>
                                        </td>
                                        <td>
                                            <span>{{tanggalIndoFull($st->created_at)}}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" onclick="edit({{$st->id}})" >Edit</button>
                                            <form action="{{url('/teacher/soal/delete/'.$st->id)}}" method="post" class="d-inline">
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
                <h4 class="modal-title" id="myModalLabel33">Add Assignment</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{url('/teacher/soal/add')}}" method="POST">
                @csrf
                <div class="modal-body">
                  <label>Name: </label>
                  <div class="mb-1">
                    <input type="text" placeholder="Class Name" class="form-control" name="name" />
                  </div>
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
                <h4 class="modal-title" id="myModalLabel33">Edit Assignment</h4>
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
                  <label for="">Status: </label>
                  <div class="mb-1">
                    <select name="status" id="status" class="form-select">
                      <option value="published">Published</option>
                      <option value="closed">Closed</option>
                    </select>
                  </div>
                  <label for="">Class: </label>
                  <div class="mb-1">
                    <select name="kelas" id="classs" class="form-select"></select>
                  </div>
                  <label for="">Subject: </label>
                  <div class="mb-1">
                    <select name="subject" id="subject" class="form-select"></select>
                  </div>
                  <label for="">File: </label>
                  <div class="mb-1">
                    <input type="file" name="subject" id="file" class="form-select">
                    <div class="col-12" id="prev-con">
                        <img alt="prev" id="prev" width="100%">
                    </div>
                  </div>
                  <label for="">Description: </label>
                  <div class="mb-1">
                    <textarea ></textarea>
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
    <script src={{asset("app-assets/vendors/js/file-uploaders/dropzone.min.js")}}></script>
    <script>
        function edit(id){
            $.ajax({
                url: `{{url('/teacher/soal/edit')}}/${id}`,
                type: "GET",
                success: function(data){
                    $('#edit #id').val(id);
                    $('#edit #name').val(data.work[0].name);
                    $('#edit #status').val(data.work[0].status);
                    $('#edit #classs').find('option').remove().end()
                    $('#edit #subject').find('option').remove().end()
                    data.kelas.forEach(element => {
                        $('#edit #classs').append(`<option value="${element.id}">${element.name}</option>`)
                    });
                    data.subject.forEach(element => {
                        $('#edit #subject').append(`<option value="${element.id}">${element.name}</option>`)
                    });
                    $('#edit #subject').val(data.work[0].subject_id);
                    $('#edit #classs').val(data.work[0].class_id);
                    $('#edit #prev-con #prev').attr('src',"{{asset('upload/')}}/"+data.work[0].file);
                    $('#edit').modal('show');
                }
            });
        }
    </script>
@endsection