{{-- \resources\views\labbooks\index.blade.php --}}
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

    <div class="col-lg-10 col-lg-offset-1">

        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>书名</th>
                    <th>借阅人姓名</th>
                    <th>借阅人邮箱</th>
                    <th>创建日期</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($labbooks as $labbook)
                    <tr>

                        <td>{{ $labbook->bookName }}</td>
                        <td>{{ $labbook->borrowerName }}</td>
                        <td>{{ $labbook->borrowerEmail }}</td>
                        <td>{{ $labbook->created_at->format('F d, Y h:ia') }}</td>
                        <td>
                            <a href="{{ URL::to('labbooks/'.$labbook->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">编辑</a>

                            {!! Form::close() !!}

                        </td>
                    </tr>
                @endforeach
                </tbody>


            </table>
        </div>

        <a href="{{ URL::to('labbooks/create') }}" class="btn btn-success">新建</a>

    </div>

@endsection


@section('footer')

    <div class="panel-body">
        <form class="form-inline" action="/labbook/search" method="get" enctype="text/plain">
            <div class="form-group">关键字:<input type="text" name="keyword"/>
                <button type="submit"> 搜索 </button></div>

        </form></div>
@endsection