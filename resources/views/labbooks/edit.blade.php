<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://use.fontawesome.com/9712be8772.js"></script>
</head>
@extends('layouts.header')

@section('content')

    <div class='col-lg-4 col-lg-offset-4'>

        <h1><i class='fa fa-key'></i> 更改 {{$labbook->bookName}} 状态</h1>
        <br>
        {{ Form::model($labbook, array('route' => array('labbooks.update', $labbook->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with labbook data --}}

        <div class="form-group">
            {{ Form::label('bookName', '书籍名称') }}
            {{ Form::text('bookName', $labbook->bookName, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('borrowerName', '借阅人姓名') }}
            {{ Form::text('borrowerName', $labbook->borrowerName, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            {{ Form::label('borrowerEmail', '借阅人邮箱') }}
            {{ Form::text('borrowerEmail', $labbook->borrowerEmail, array('class' => 'form-control')) }}
        </div>

        <br>
        {{ Form::submit('更改', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>

@endsection