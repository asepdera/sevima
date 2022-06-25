@extends('layout.layout_student')

@section('title', 'Student Assignment')
@section('name',auth()->user()->name)
@section('role',auth()->user()->role)

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Assignment</h3>
        </div>
        <div class="card-body">
            <div class="overflow-x-scroll" style="overflow-y: hidden !important;">
                <table class="table table-striped">
                    <thead>
                        <th>No</th>
                        <th>Name</th>
                        <th>Start In</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if (count($work) == 0)
                            <tr>
                                <td colspan="3">No Data</td>
                            </tr>
                        @else
                            @foreach ($work as $w)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <span>{{$w->name}}</span>
                                    </td>
                                    <td>
                                        {{tanggalIndoFull($w->created_at)}}
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" onclick="edit({{$w->id}})">View</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @error('file')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Completed Assignment</h3>
        </div>
        <div class="card-body">
            <div class="overflow-x-scroll" style="overflow-y: hidden !important;">
                <table class="table table-striped">
                    <thead>
                        <th>No</th>
                        <th>Name</th>
                        <th>Complete In</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @if ($complete == null)
                            <tr>
                                <td colspan="3">No Data</td>
                            </tr>
                        @else
                            @foreach ($complete as $w)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <span>{{$w->work_name}}</span>
                                    </td>
                                    <td>
                                        {{tanggalIndoFull($w->created_at)}}
                                    </td>
                                    <td>
                                        {{$w->status}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
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
                <h4 class="modal-title" id="myModalLabel33">Detail Assignment</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div> 
              <div class="col-12 p-1">
                <div id="attach" class="cursor-pointer">
                    <img alt="" width="100%" height="300px">
                    <span id="ka"></span>
                </div>
                <div id="desc"></div>
              </div>
              <form action="{{url('/student/soal/submit/')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <label>Name: <span id="kla"></span></label>
                  <input type="hidden" name="id" id="id">
                  <div class="mb-1">

                    <input type="hidden" placeholder="Class Name" class="form-control" name="name" id="name" />
                  </div>
                  <label for="">File: </label>
                  <div class="input-group form-password-toggle mb-2">
                    <input
                      type="file"
                      class="form-control"
                      name="file"
                    />
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="submit" class="btn btn-primary" data-bs-dismiss="modal" value="Submit">
                </div>
              </form>
            </div>
          </div>
        </div>
@endsection
@section('script')
    <script>
        function edit(id){
            $('#edit').modal('show');
            $.ajax({
                url: `{{url('/student/soal/edit')}}/${id}`,
                type: "GET",
                success: function(data){
                    $('#id').val(id);
                    $('#attach').attr('onclick',`download(${id})`)
                    $('#attach img').attr('src',`{{asset('upload')}}/${data.work.file}`);
                    $('#attach #ka').text(`File Name : ${data.work.file}`);
                    $('#desc').text(`Description : ${data.work.description}`);
                    $('#name').val(data.work.name);
                    $('#kla').text(data.work.name);
                }
            });
        }
        function download (id){
            window.location.href = "{{url('/student/soal/download')}}/"+id;
        }
    </script>
@endsection