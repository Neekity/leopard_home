<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Consts extends Model
{
    const FILE_SUFFIX=['gif','jpg','png','js','css','jpeg','pdf','doc','docx','ppt','pptx','mp4'];
    const FILE_SUFFIX_STR='gif,jpg,png,js,css,jpeg,pdf,doc,docx,ppt,pptx,mp4';
}
