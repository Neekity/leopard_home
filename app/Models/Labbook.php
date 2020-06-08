<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Labbook extends Model
{
    protected $table='lab_books';
    protected $fillable=['$bookName','borrowerName','borrowerEmail'];
}
