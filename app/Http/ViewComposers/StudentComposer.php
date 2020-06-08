<?php


namespace App\Http\ViewComposers;


use App\Models\Student;
use Illuminate\Contracts\View\View;

class StudentComposer
{
    protected $stuItem;
    protected $isRole;//是否是超级管理员
    public function __construct()
    {
        $this->stuItem=Student::select('name','email')->get();
        $this->isRole=!auth()->guest() and auth()->user()->hasAnyRole('超级管理员');
    }

    public function compose(View $view){
        $view->with('stuItem',$this->stuItem);
        $view->with('isRole',$this->isRole);
    }
}