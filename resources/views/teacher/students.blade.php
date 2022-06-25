@extends('layout.layout_teacher')

@section('title','Students')
@section('name',auth()->user()->name)
@section('role',auth()->user()->role)

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Students</div>
            </div>
            <div class="card-body">
                <div class="overflow-x-scroll" style="overflow-y: hidden !important;">
                    <table class="table table-striped">
                        <thead>
                            <th>No</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Phone</th>
                        </thead>
                        <tbody>
                            @if (count($students) == 0)
                                <tr>
                                    <td colspan="4">No Data</td>
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
                                        <td>{{$st->phone}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection