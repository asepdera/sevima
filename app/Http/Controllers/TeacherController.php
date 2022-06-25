<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Kelas;
use App\Models\Work;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $data['kelas'] = Kelas::where('user_id', \Auth::user()->id)->get();
        $data['students'] = \collect();
        foreach ($data['kelas'] as $kelas) {
            $data['students'] = $data['students']->merge(
                User::join('user_details','user_details.user_id','=','users.id')
                    ->join('class','class.id','=','user_details.class_id')
                    ->where('user_details.class_id', $kelas->id)
                    ->where('users.role', 'student')
                    ->select('users.email', 'users.name', 'user_details.phone', 'user_details.class_id', 'user_details.images', 'class.name as class_name')
                    ->limit(2)
                    ->get()
            );
        }
        $data['latest_work'] = Work::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(1)->get();
        $data['work'] = Work::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->limit(5)->get();
        return view('teacher/dashboard', $data);
    }
    public function students(){
        $data['kelas'] = Kelas::where('user_id', \Auth::user()->id)->get();
        $data['students'] = \collect();
        foreach ($data['kelas'] as $kelas) {
            $data['students'] = $data['students']->merge(
                User::join('user_details','user_details.user_id','=','users.id')
                    ->join('class','class.id','=','user_details.class_id')
                    ->where('user_details.class_id', $kelas->id)
                    ->where('users.role', 'student')
                    ->select('users.email', 'users.name', 'user_details.phone', 'user_details.class_id', 'user_details.images', 'class.name as class_name')
                    ->get()
            );
        }
        return view('teacher.students', $data);
    }
}
