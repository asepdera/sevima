@extends('layout.layout_teacher')

@section('title','Dashboard Teacher')
@section('role',auth()->user()->role)
@section('name',auth()->user()->name)

@section('content')
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Students
                </h3>
            </div>
            <div class="card-body">1</div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Latest Student Work</h3>
            </div>
            <div class="card-body">1</div>
        </div>
    </div>
@endsection