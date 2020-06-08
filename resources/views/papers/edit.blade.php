@extends('layouts.header')


@section('content')

    <div class='col-lg-4 col-lg-offset-4'>

        <h1><i class='fa fa-key'></i> 更改 {{$paper->fileName}} </h1>
        <br>
        {{ Form::model($paper, array('route' => array('papers.update', $paper->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with paper data --}}

        <div class="form-group">
            {{ Form::label('originName', '文件名称') }}
            {{ Form::text('originName', $paper->originName, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('fileName', '文件地址') }}
            {{ Form::text('fileName', $paper->fileName, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('FirstAuthor', '第一作者') }}
            {{ Form::text('FirstAuthor', $paper->FirstAuthor, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('communicationAuthor', '通讯作者') }}
            {{ Form::text('communicationAuthor', $paper->communicationAuthor, array('class' => 'form-control')) }}
        </div>
        <br>
        {{ Form::submit('更改', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>

@endsection