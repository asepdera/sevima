@extends('layout.layout_student')

@section('title','Dashboard Student')
@section('role',auth()->user()->role)
@section('name',auth()->user()->name)

@section('sidebar')
    
@endsection

@section('content')

@endsection