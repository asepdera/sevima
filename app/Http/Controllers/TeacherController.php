<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Kelas;
use App\Models\Work;
use App\Models\Subject;

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
                    ->select('users.email', 'users.name', 'user_details.class_id', 'user_details.images', 'class.name as class_name')
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
    public function kelas(){
        $data['kelas'] = Kelas::where('user_id', \Auth::user()->id)->get();
        return view('teacher.kelas', $data);
    }
    public function add_kelas(){
        $validation = $this->validate(request(), [
            'name' => 'required|string|max:255',
        ]);

        $kelas = new Kelas;
        $kelas->name = request('name');
        $kelas->user_id = \Auth::user()->id;
        $kelas->class_code = $this->generateRandomString(6);
        $kelas->save();
        return redirect('/teacher/kelas');
    }
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function delete_kelas($id){
        $kelas = Kelas::find($id);
        $kelas->delete();
        return redirect('/teacher/kelas');
    }

    public function edit_kelas($id){
        try {
            $kelas = Kelas::find($id);
            $data['kelas'] = $kelas;
        } catch (\Exception $e) {
            return response()->json($e);
        }
        return response()->json($data);
    }

    public function update_kelas(){
        $validation = $this->validate(request(), [
            'name' => 'required|string|max:255',
        ]);

        $kelas = Kelas::find(request('id'));
        $kelas->name = request('name');
        $kelas->save();
        return redirect('/teacher/kelas');
    }

    public function soal(){
        $data['soal'] = Work::join('class','class.id','=','works.class_id')
            ->where('works.user_id', \Auth::user()->id)
            ->select('works.id', 'works.name', 'works.status', 'class.name as class_name', 'works.created_at',)
            ->get();
        return view('teacher/soal', $data);
    }

    public function add_soal(){
        $validation = $this->validate(request(), [
            'name' => 'required|string|max:255',
            'class_id' => 'required|integer',
        ]);

        $work = new Work;
        $work->name = request('name');
        $work->user_id = \Auth::user()->id;
        $work->class_id = request('class_id');
        $work->save();
        return redirect('/teacher/soal');
    }

    public function delete_soal($id){
        $work = Work::find($id);
        $work->delete();
        return redirect('/teacher/soal');
    }

    public function edit_soal($id){
        try {
            $work = Work::join('class','class.id','=','works.class_id')
                ->join('subjects','subjects.id','=','works.subject_id')
                ->where('works.id', $id)
                ->select(
                    'works.id', 
                    'works.name', 
                    'works.status', 
                    'class.id as class_id',
                    'class.name as class_name',
                    'works.created_at',
                    'works.file',
                    'subjects.name as subject_name',
                    'subjects.id as subject_id'
                )
                ->get();
            $kelas = Kelas::where('user_id', \Auth::user()->id)->get();
            $subject = Subject::where('user_id', \Auth::user()->id)->get();
            $data['work'] = $work;
            $data['kelas'] = $kelas;
            $data['subject'] = $subject;
        } catch (\Exception $e) {
            return response()->json($e);
        }
        return response()->json($data);
    }
}
