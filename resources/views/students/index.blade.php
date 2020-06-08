<head>
    <meta charset="utf-8" />
    <title>{{$student->name}}主页</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">


</head>
@extends('layouts.header')
@section('content')
<body style="text-align:center;">
<div class="container">
<table>
    <td>
            <ul >
                @foreach($stuItem as $tmp)
                    <li>
                    <a href="/student/show/{{$tmp->email}}">{{$tmp->name}}</a>
                    </li>
                    @endforeach
            </ul>

    </td>
   <td>
       <div class="col-lg-10 col-lg-offset-1">
           <div class="table-responsive" align="left">
               <table class="table table-bordered" >
                   <tr>
                       <td><img src="{{$student->url}}" width="200" height="212"></td>
                       <td>
                           <h3>{{$student->name}}</h3>
                           {{$student->Uinfo}}
                           <br />
                           研究方向：{{$student->field}}
                           <br />
                           <br />
                           办公地址：{{$student->address}}
                           <br />
                           邮政编码：200240
                           <br />
                           电子邮箱：{{$student->email}}
                       </td>
                   </tr>
               </table>
               <p>
                   <strong>个人简介：</strong>
                   @foreach($student->info as $tmpInfo)
                       <br />{{$tmpInfo.'。'}}
               @endforeach
               <p align="left">
                   <strong>发表论文：</strong>
               <div class="table-responsive">
                   <table class="table table-bordered table-striped">

                       <thead>
                       <tr>
                           <th>论文名称</th>
                           <th>第一作者</th>
                           <th>通讯作者</th>
                           <th>操作</th>
                       </tr>
                       </thead>
                       <tbody>
                       @foreach ($papers as $paper)
                           <tr>
                               <td>{{ $paper->originName }}</td>
                               <td>{{ $paper->FirstAuthor }}</td>
                               <td>{{ $paper->communicationAuthor }}</td>
                               <td>
                                   <a href="{{ URL::to($paper->fileName) }}" class="btn btn-info pull-left" style="margin-right: 3px;">下载</a>

                                   {!! Form::close() !!}

                               </td>
                           </tr>
                       @endforeach
                       </tbody>
                   </table>
               </div>


           </div>
       </div>
   </td>
</table>
</div>
</body>
@endsection