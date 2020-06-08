<?php


namespace App\Http\Controllers;


use App\Models\Prize;

class PrizeController
{
    public function index(){
        $prizes = Prize::all();
        return view('yulaoshi.prize',['prizes'=>$prizes]);
    }
}