<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Models\Paper;
use App\Models\Resource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public static function test()
    {
        var_dump(Auth::user);
    }

    public function upload(Request $request)
    {
        if ($request->isMethod('POST')) {
            $file = $request->file('file');
            //判断文件是否上传成功
            if ($file->isValid()) {
                //原文件名
                $originalName = $file->getClientOriginalName();
                $nameArr=explode('.',$originalName);
                if(!in_array($nameArr[count($nameArr)-1],Consts::FILE_SUFFIX)){
                    return redirect('resources')->with('flash_message',
                        '请以'.Consts::FILE_SUFFIX_STR.'结尾！');
                }
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //MimeType
                $type = $file->getClientMimeType();
                //临时绝对路径
                $realPath = $file->getRealPath();
                $filename = uniqid() . '.' . $ext;
                //nginx给出相应的配置
                $bool     = Storage::disk('local')->put($filename, file_get_contents($realPath));
                //判断是否上传成功
                if ($bool) {
                    $resource = new Resource(
                        [
                            'fileName'    => $originalName,
                            'fileUrl'     => $filename,
                            'fileType'    => $ext,
                            'uploadId'    => Auth::user()->id,
                            'uploadName'  => Auth::user()->name,
                            'uploadEmail' => Auth::user()->email,
                        ]
                    );
                    $resource->save();
                    if ($ext == 'pdf') {
                        $paper = new Paper(
                            [
                                'fileName'   => $filename,
                                'paperUrl'   => $filename,
                                'originName' => $originalName,
                                'communicationAuthor'=>'',
                                'FirstAuthor'=>''
                            ]
                        );
                        $paper->save();

                    }
                    if($ext=='pdf'){
                        return redirect('papers')->with('flash_message',
                            '成功上传' . $originalName);
                    }else{
                        return redirect('resources')->with('flash_message',
                            '成功上传' . $originalName);
                    }

                } else {
                    return redirect('resources')->with('flash_message',
                        '上传' . $originalName . '失败');
                }
            }
        }

    }
}
