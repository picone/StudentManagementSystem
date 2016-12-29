@extends('vendor.layout')
@section('content')
    @include('navigation')
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                {{ Session::get('message') }}
            </div>
        @endif
        {!! Form::open(['method'=>'get']) !!}
            <div class="pull-right">
                <div class="col-xs-6">
                    {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'学生姓名']) !!}
                </div>
                <div class="col-xs-3">
                    {!! Form::submit('搜索',['class'=>'btn btn-success']) !!}
                </div>
            </div>
        {!! Form::close() !!}
        <table class="table">
            <thead>
            <tr>
                <th>学生名</th>
                <th>课程名</th>
                <th>选择时间</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($score as &$val)
                <tr>
                    <td>{{ $val->student->name }}</td>
                    <td>{{ $val->course->name }}</td>
                    <td>{{ $val->createAt }}</td>
                    <td>{!! Html::link(route('course:dismiss',['student_id'=>$val->student_id,'course_id'=>$val->course_id]),'退选',['class'=>'btn btn-danger']) !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $score->links() !!}
    </div>
@stop
@section('js')
    <script>
        $(()=>{

        });
    </script>
@stop