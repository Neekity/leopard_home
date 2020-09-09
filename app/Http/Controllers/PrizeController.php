<?php


namespace App\Http\Controllers;


use App\Models\Prize;

class PrizeController
{
    public function index(){
        $prizes = Prize::all();
        return view('prize.prize',['prizes'=>$prizes]);
    }
}