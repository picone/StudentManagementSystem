@extends('vendor.layout')
@section('content')
    @include('navigation')
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                {{ Session::get('message') }}
            </div>
        @endif
        <table class="table">
            <thead>
            <tr>
                <th>科目</th>
                <th>学时</th>
                <th>学分</th>
                <th>学期</th>
                <th>任课老师</th>
                <th>选课时间<a href="{!! route('student:course',['order'=>'time'],false) !!}"><i class="caret"></i></a></th>
                <th>平时成绩</th>
                <th>期末成绩</th>
                <th>总评成绩<a href="{!! route('student:course',['order'=>'score'],false) !!}"><i class="caret"></i></a></th>
            </tr>
            </thead>
            <tbody>
            @foreach($score as $val)
                <tr>
                    <td>{{ $val->course->name }}</td>
                    <td>{{ $val->course->hour }}</td>
                    <td>{{ $val->course->credit }}</td>
                    <td>{{ $val->term }}</td>
                    <td>{{ $val->course->teacher->name }}</td>
                    <td>{{ $val->createAt }}</td>
                    @if($val->score)
                        <td>{{ $val->regular_score }}</td>
                        <td>{{ $val->regular_score }}</td>
                        <td>{{ $val->score }}</td>
                    @else
                        <td colspan="3">未评分</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
@section('js')
    <script>
        $(()=>{
            $('.save').click(function(){
                let parent = $(this).parents('tr');
                let regular_score = parent.find('input[name=regular_score]'),exam_score = parent.find('input[name=exam_score]');
                $.post(location.pathname,{id:$(this).data('id'),course:$(this).data('course'),regular_score:regular_score.val(),exam_score:exam_score.val()},function(data){
                    if(data.code==1){
                        regular_score.attr('disabled',true);
                        exam_score.attr('disabled',true);
                        parent.find('.score').text(data.data.score);
                    }else{
                        alert(data.msg);
                    }
                });
            });
        });
    </script>
@stop