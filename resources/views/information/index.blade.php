{{-- \resources\views\permissions\index.blade.php --}}
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

        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>姓名</th>
                    <th>照片名称</th>
                    <th>照片地址</th>
                    <th>研究生</th>
                    <th>研究方向</th>
                    <th>个人简介</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $paper->fileName }}</td>
                        <td>{{ $paper->FirstAuthor }}</td>
                        <td>{{ $paper->communicationAuthor }}</td>
                        <td>
                            <a href="{{ URL::to('papers/'.$paper->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">编辑</a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['papers.destroy', $paper->id] ]) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


    </div>

@endsection