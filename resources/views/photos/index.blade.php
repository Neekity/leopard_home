@extends('layouts.header')
@section('content')
    <head>
        <meta charset="UTF-8" />
        <title>肖家军图片集</title>
        <style>
            *{margin: 0; padding: 0; list-style: none; border: none;}
            div{
                display: flex;/*显示模式设置为弹性盒子*/
                flex-wrap: wrap;/*进行强制换行*/
            }
            div:after{
                /*对最后一个伪元素进行最大限度伸缩*/
                content: ' ';
                flex-grow: 999999999999999999999999999999999999;
            }
            img{
                height: 300px;/*高度*/
                width: auto;
                margin: 2px;
                flex-grow: 1;/*进行按比例伸缩*/
                object-fit: cover;/*进行裁切，并且图片按比例缩放*/
            }
        </style>
    </head>
<div>
    @foreach($photos as$photo)
        <img src={{$photo->fileUrl}} alt="" />
        @endforeach

</div>
@endsection
