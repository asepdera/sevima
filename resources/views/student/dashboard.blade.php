@extends('layout.layout_student')

@section('title','Dashboard Student')

@section('sidebar')
    <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="book"></i><span class="menu-title text-truncate" data-i18n="Data">Data</span></a>
        <ul class="menu-content">
            <li><a class="d-flex align-items-center" href="{{url('/teacher/students')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Roles">Students</span></a>
            </li>
            <li><a class="d-flex align-items-center" href="{{url('/teacher/kelas')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Permission">Class</span></a>
            </li>
            <li><a class="d-flex align-items-center" href="{{url('/teacher/soal')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Permission">Questions</span></a>
            </li>
            <li><a class="d-flex align-items-center" href="{{url('/teacher/subject')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Permission">Subjects</span></a>
            </li>
            <li><a class="d-flex align-items-center" href="{{url('/teacher/exam')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Permission">Exam</span></a>
            </li>
        </ul>
    </li>
    <li class=" nav-item"><a class="d-flex align-items-center" href="app-file-manager.html"><i data-feather="save"></i><span class="menu-title text-truncate" data-i18n="File Manager">File Manager</span></a>
    </li>
@endsection

@section('content')

@endsection