<?php


namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Support\Facades\Route;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController
{
    public function lab(){
        $cols=3;
        $students=Student::all();
        $rows=ceil(count($students)/$cols);
        return view('students.lab',['students'=>$students,'rows'=>$rows,'count'=>count($students),'cols'=>$cols]);
    }
    public function index(){
        $email=Auth::user()->email;
        $student=Student::
            where('email','=',$email)
            ->get()[0];
        //return $student;
        $student->info=explode('。',$student->info);
        $papers=Paper::where('FirstAuthor','=',Auth::user()->name)->get();
        return view('students.index',['student'=>$student,'papers'=>$papers]);
    }

    public function jump(){
        $email=Route::input('email');
        $student=Student::
        where('email','=',$email)
            ->get()[0];
        //return $student;
        $student->info=explode('。',$student->info);
        $papers=Paper::where('FirstAuthor','=',$student->name)->get();
        return view('students.index',['student'=>$student,'papers'=>$papers]);
    }

}