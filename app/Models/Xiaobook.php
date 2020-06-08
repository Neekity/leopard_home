<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Xiaobook extends Model
{
    protected $table='lab_books';
    protected $fillable=['$bookName','borrowerName','borrowerEmail'];
}