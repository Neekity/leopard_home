@extends('layouts.header')
@section('content')
    @foreach($videos as $video)
        <a href={{$video->fileUrl}} target="_blank">
    <video width="320" height="240" controls>
        <h5>{{$video->fileName}}</h5>
            <source src={{$video->fileUrl}}>
        您的浏览器不支持 video 标签。
    </video>
        </a>
    @endforeach
@endsection
