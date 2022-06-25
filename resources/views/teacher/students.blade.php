@extends('layout.layout_teacher')

@section('title','Students')
@section('name',auth()->user()->name)
@section('role',auth()->user()->role)

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title"></div>
            </div>
            <div class="card-body"></div>
        </div>
    </div>
@endsection