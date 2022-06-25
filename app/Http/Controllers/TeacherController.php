<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Kelas;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $data['kelas'] = Kelas::where('user_id', \Auth::user()->id)->get();
        $data['students'] = \collect();
        foreach ($data['kelas'] as $kelas) {
            $data['students'] = $data['students']->merge(User::where('kelas_id', $kelas->id)->get());
        }
        return view('teacher/dashboard');
    }
}
