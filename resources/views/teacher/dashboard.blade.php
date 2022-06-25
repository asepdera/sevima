@extends('layout.layout_teacher')

@section('title','Dashboard Teacher')
@section('role',auth()->user()->role)
@section('name',auth()->user()->name)

@section('content')
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4>Students</h4>
                <h4>{{$students->count()}}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4>Latest Student Assignment</h3>
                @if (count($work) == 0)
                    <h4>No Data</h4>
                @else
                    @foreach ($latest_work as $w)
                        <h4>{{$w->name}}</h4>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Students</h3>
                    <a class="btn btn-primary btn-sm" href="">See All -></a>
                </div>
                <div class="card-body">
                    <div class="overflow-x-scroll" style="overflow-y: hidden !important;">
                        <table class="table table-striped">
                            <thead>
                                <th>No</th>
                                <th>Name</th>
                                <th>Class</th>
                            </thead>
                            <tbody>
                                @if (count($students) == 0)
                                    <tr>
                                        <td colspan="3">No Data</td>
                                    </tr>
                                @else
                                    @foreach ($students as $st)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <span class="avatar mr-1">
                                                    @if ($st->images)
                                                        <img src="{{asset('upload/'.$st->images)}}" alt="profile" height="40" width="40">
                                                    @endif
                                                    <img src="{{asset('upload/no-user.png')}}" alt="profile" height="40" width="40">
                                                </span>
                                                <span>{{$st->name}}</span>
                                            </td>
                                            <td>{{$st->class_name}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Student Assignment</h3>
                    <a class="btn btn-primary btn-sm" href="">See All -></a>
                </div>
                <div class="card-body">
                    <div class="overflow-x-scroll" style="overflow-y: hidden !important;">
                        <table class="table table-striped">
                            <thead>
                                <th>No</th>
                                <th>Name</th>
                                <th>Status</th>
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
                                                @if ($w->status == 'closed')
                                                    <span class="badge bg-danger">{{$w->status}}</span>
                                                @else
                                                    <span class="badge bg-success">{{$w->status}}</span>
                                                @endif
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
    </div>
@endsection