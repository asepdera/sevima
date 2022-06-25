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
        $kelas->update();
        return redirect('/teacher/kelas');
    }

    public function soal(){
        $data['soal'] = Work::join('class','class.id','=','works.class_id')
            ->where('works.user_id', \Auth::user()->id)
            ->select('works.id', 'works.name', 'works.status', 'class.name as class_name', 'works.created_at',)
            ->get();
        $kelas = Kelas::where('user_id', \Auth::user()->id)->get();
        $subject = Subject::where('user_id', \Auth::user()->id)->get();
        $data['kelas'] = $kelas;
        $data['subject'] = $subject;
        return view('teacher/soal', $data);
    }

    public function add_soal(){
        $validation = $this->validate(request(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'files' => 'required|max:10000',
            'status' => 'required|string',
        ]);
        
        $work = new Work;
        $work->name = request('name');
        $work->user_id = \Auth::user()->id;
        $work->class_id = request('kelas');
        $work->subject_id = request('subject');
        $work->status = request('status');
        $work->description = request('description');
        
        $file = request()->file('files');
        $file_name = time().'.'.$file->extension();
        
        $file->move(public_path('/upload'), $file_name);
        $work->file = $file_name;

        $work->save();
        return redirect('/teacher/soal');
    }

    public function soal_delete($id){
        $work = Work::find($id);
        $file = $work->file;

        if(file_exists(public_path('/upload/'.$file))){
            unlink(public_path('/upload/'.$file));
        }
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
                    'works.description',
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

    public function soal_update(){
        $validation = $this->validate(request(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'files' => 'required|max:10000',
            'status' => 'required|string',
        ]);
        
        $work = Work::find(request('id'));
        //delete old file
        $file = $work->file;

        if(file_exists(public_path('/upload/'.$file))){
            unlink(public_path('/upload/'.$file));
        }
        $work->name = request('name');
        $work->user_id = \Auth::user()->id;
        $work->class_id = request('kelas');
        $work->subject_id = request('subject');
        $work->status = request('status');
        $work->description = request('description');
        
        $file = request()->file('files');
        $file_name = time().'.'.$file->extension();
        
        $file->move(public_path('/upload'), $file_name);
        $work->file = $file_name;

        $work->update();
        return redirect('/teacher/soal');
    }

    public function subject(){
        $data['subject'] = Subject::where('user_id', \Auth::user()->id)->get();
        return view('teacher/subject', $data);
    }
    public function update_subject(){
        $validation = $this->validate(request(), [
            'name' => 'required|string|max:255',
        ]);

        $subject = Subject::find(request('id'));
        $subject->name = request('name');
        $subject->update();
        return redirect('/teacher/subject');
    }
    public function delete_subject($id){
        $subject = Subject::find($id);
        $subject->delete();
        return redirect('/teacher/subject');
    }

    public function edit_subject($id){
        try {
            $subject = Subject::find($id);
            $data['subject'] = $subject;
        } catch (\Exception $e) {
            return response()->json($e);
        }
        return response()->json($data);
    }
    public function add_subject(){
        $validation = $this->validate(request(), [
            'name' => 'required|string|max:255',
        ]);

        $subject = new Subject;
        $subject->name = request('name');
        $subject->user_id = \Auth::user()->id;
        $subject->save();
        return redirect('/teacher/subject');
    }

    public function profile(){
        $data['user'] = User::join('user_details','user_details.user_id','=','users.id')
            ->where('users.id', \Auth::user()->id)
            ->select('users.id', 'users.name', 'users.email', 'user_details.phone', 'user_details.images')
            ->get();
        return view('teacher/profile', $data);
    }

    public function profile_update(){
        $validation = $this->validate(request(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|max:15',
            'files' => 'max:10000',
            'email' => 'required|email',
        ]);
        
        $users = UserDetail::where('user_id', \Auth::user()->id)->first();
        $user = User::find(\Auth::user()->id);
        // dd($users);
        //delete old file
        $user->name = request('name');
        $users->user_id = \Auth::user()->id;
        $users->phone = request('phone');
        $user->email = request('email');
        $file = request()->file('files');
        if ($file) {
            $filed = $users->images;

            if($filed){
                unlink(public_path('/user/'.$filed));
            }
            $file_name = time().'.'.$file->extension();
        
            $file->move(public_path('/user'), $file_name);
            $users->images = $file_name;
        }

        $user->update();
        $users->update();
        return redirect('/teacher/profile');
    }
}
