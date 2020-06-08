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
                    <th>资源名称</th>
                    <th>资源地址</th>
                    <th>文件类型</th>
                    <th>上传者</th>
                    <th>上传日期</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($resources as $resource)
                    <tr>
                        <td>{{ $resource->fileName }}</td>
                        <td>{{ $resource->fileUrl }}</td>
                        <td>{{ $resource->fileType }}</td>
                        <td>{{ $resource->uploadName }}</td>
                        <td>{{ $resource->created_at->format('F d, Y h:ia') }}</td>
                        <td>
                            <a href="{{ URL::to($resource->fileUrl) }}" class="btn btn-info pull-left" style="margin-right: 3px;">下载</a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['resources.destroy', $resource->id] ]) !!}
                            {!! Form::submit('删除', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        {{ $resources->appends(['keyword'=>$keyword])->links() }}

    </div>
@endsection
@section('footer')
    <table class="table table-bordered table-striped">
        <tr>
        <th>搜索模块</th>
        <th>上传模块</th>
        </tr>
        <tr>
            <td><div class="panel-body">
                    <form class="form-inline" action="resource/search" method="get" enctype="text/plain">
                        <div class="form-group">关键字:<input type="text" name="keyword"/>
                            <button type="submit"> 搜索 </button></div>

                    </form></div></td>
            <td><div class="panel-body">
                    <form class="form-inline" method="post" action="/upload" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="file" name="file"> <button type="submit"> 提交 </button>
                        </div>
                    </form>
                </div></td>

        </tr>

    </table>
    @endsection

