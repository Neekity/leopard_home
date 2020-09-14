<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use ModelTrait;
    protected $fillable = ['fileName', 'fileUrl', 'fileType', 'uploadName', 'uploadEmail', 'uploadId'];

    public function uploader()
    {
        return $this->hasOne(User::class, 'id', 'uploadId');
    }
}
