<head>
    <meta charset="utf-8" />
    <title>肖家军</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">


</head>
@extends('layouts.header')
@section('content')
    <div class="container">

        <div class="col-lg-10 col-lg-offset-1">
            <div class="table-responsive" align="left">
                <table class="table table-bordered" >
                    @foreach(range(0,$rows-1) as $i)
                        <tr>
                            @foreach(range(0,$cols) as $j)
                                <td>
                                    @if($cols*$i+$j<$count)
                                        @php ($student=$students[$cols*$i+$j])

                                        <img src="{{$student->url}}" width="200" height="212" >
                                        <br><br>
                                        <a href="/student/show/{{$student->email}}">{{$student->name}}</a>
                                        <br>
                                        {{$student->Uinfo}}
                                        <br>
                                        {{$student->field}}
                                    @endif
                                </td>
                            @endforeach

                        </tr>
                    @endforeach
                </table>


            </div>
        </div>

    </div>
@endsection


@section('footer')
@endsection