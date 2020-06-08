@extends('layouts.header')


@section('content')

    <div class='col-lg-4 col-lg-offset-4'>

        <h1><i class='fa fa-key'></i> 新增角色 </h1>
        <hr>

        {{ Form::open(array('url' => 'roles')) }}

        <div class="form-group">
            {{ Form::label('name', '名称') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>

        <h5><b>分配权限</b></h5>

        <div class='form-group'>
            @foreach ($permissions as $permission)
                {{ Form::checkbox('permissions[]',  $permission->id ) }}
                {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>

            @endforeach
        </div>

        {{ Form::submit('增加', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>

@endsection