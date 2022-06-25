<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\WorkLog;
use App\Models\User;
use App\Models\Kelas;
use App\Models\UserDetail;

class StudentsController extends Controller
{
    public function dashboard()
    {
        $data['complete_work'] = Work::with('work_log')
            ->whereHas('work_log', function ($query) {
                $query->where('user_id', auth()->user()->id)->where('status', 'complete');
            })->count();
        $data['latest_work'] = Work::join('work_logs','work_logs.work_id','=','works.id')
            ->where('work_logs.user_id',auth()->user()->id)
            ->where('work_logs.status','complete')
            ->select('works.name')
            ->orderBy('work_logs.created_at','desc')->first();
        $data['work'] = Work::join('user_details','user_details.class_id','=','works.class_id')
            ->join('class','class.id','=','user_details.class_id')
            ->with('work_log')
            ->whereDoesntHave('work_log',function($query){
                $query->where('user_id',auth()->user()->id);
            })
            ->where('user_details.user_id',auth()->user()->id)
            ->select('works.name as work_name','works.id','class.name as class_name')
            ->limit(5)
            ->get();
        $data['assigned_work'] = Work::join('work_logs','work_logs.work_id','=','works.id')
            ->where('work_logs.user_id',auth()->user()->id)
            ->where('work_logs.status','complete')->limit(5)->get(['works.name','work_logs.status']);
        return view('student/dashboard',$data);
    }
    public function soal()
    {
        $data['complete'] = Work::join('work_logs','work_logs.work_id','=','works.id')
            ->where('work_logs.user_id',auth()->user()->id)
            ->where('work_logs.status','complete')
            ->select('works.name as work_name','work_logs.*')
            ->orderBy('work_logs.created_at','desc')->get();
        $data['work'] = Work::join('user_details','user_details.class_id','=','works.class_id')
            ->join('class','class.id','=','user_details.class_id')
            ->with('work_log')
            ->whereDoesntHave('work_log',function($query){
                $query->where('user_id',auth()->user()->id);
            })
            ->where('user_details.user_id',auth()->user()->id)
            ->select('works.*')
            ->get();
        return view('student/soal',$data);
    }

    public function download($id)
    {
        $work = Work::find($id);
        $file = public_path('upload/'.$work->file);
        return response()->download($file);
    }

    public function profile(){
        $data['user'] = User::join('user_details','user_details.user_id','=','users.id')
            ->join('class','class.id','=','user_details.class_id')
            ->where('users.id', \Auth::user()->id)
            ->select('users.id', 'users.name', 'users.email','class.class_code as class_code', 'user_details.phone','user_details.class_id', 'user_details.images')
            ->get();
        return view('student/profile', $data);
    }
    public function profile_update(){
        $validation = $this->validate(request(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|max:15',
            'files' => 'max:10000',
            'email' => 'required|email',
        ]);
        $class_id = Kelas::where('class_code', request('class_code'))->first()->id;
        $users = UserDetail::where('user_id', \Auth::user()->id)->first();
        $user = User::find(\Auth::user()->id);
        //delete old file
        $user->name = request('name');
        $users->user_id = \Auth::user()->id;
        $users->class_id = $class_id;
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
        return redirect('/student/profile');
    }

    public function view_soal($id){
        $data['work'] = Work::find($id);
        return response()->json($data);
    }

    public function submit_soal(){
        $validation = $this->validate(request(), [
            'file' => 'required|max:10000',
        ]);
        $id = request('id');
        $work = Work::find($id);
        $file = request()->file('file');
        $file_name = time().'.'.$file->extension();
        $file->move(public_path('/upload'), $file_name);
        $work_log = new WorkLog;
        $work_log->user_id = \Auth::user()->id;
        $work_log->work_id = $id;
        $work_log->file = $file_name;
        $work_log->status = 'complete';
        $work_log->save();
        return redirect('/student/soal');
    }
}
