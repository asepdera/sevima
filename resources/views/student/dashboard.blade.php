@extends('layout.layout_student')

@section('title','Dashboard Student')
@section('role',auth()->user()->role)
@section('name',auth()->user()->name)

@section('content')
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4>Assignment Complete</h4>
                <h4>{{$complete_work}}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4>Latest Complete Assignment</h4>
                @if ($latest_work == null)
                    <h4>No Data</h4>
                @else
                    <h4>{{$latest_work->name}}</h4>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assignment</h3>
                    <a class="btn btn-primary btn-sm" href="{{url('/student/soal')}}">See All -></a>
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
                                @if (count($work) == 0)
                                    <tr>
                                        <td colspan="3">No Data</td>
                                    </tr>
                                @else
                                    @foreach ($work as $w)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <span>{{$w->work_name}}</span>
                                            </td>
                                            <td>
                                                {{$w->class_name}}
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
        <div class="col-lg-5 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Completed Assignment</h3>
                    <a class="btn btn-primary btn-sm" href="{{url('/teacher/soal')}}">See All -></a>
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
                                @if (count($assigned_work) == 0)
                                    <tr>
                                        <td colspan="3">No Data</td>
                                    </tr>
                                @else
                                    @foreach ($assigned_work as $w)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <span>{{$w->name}}</span>
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
        </div>
    </div>
@endsection