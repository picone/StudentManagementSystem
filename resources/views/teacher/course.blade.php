@extends('vendor.layout')
@section('content')
    @include('navigation')
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                {{ Session::get('message') }}
            </div>
        @endif
        @foreach($course as $key=>&$val)
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <span class="text-center">{{ $val->name }}</span>
                        <span class="pull-right"><a href="#p{{ $key }}" data-toggle="collapse" style="color:#ffffff;cursor:pointer;" aria-expanded="false"><i class="caret"></i></a></span>
                    </div>
                </div>
                <div class="panel-collapse collapse in" id="p{{ $key }}">
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>学号</th>
                                <th>姓名</th>
                                <td>性别</td>
                                <td>专业</td>
                                <td width="100">平时成绩</td>
                                <td width="100">期末成绩</td>
                                <td>总评成绩</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($val->scores as $score)
                                <tr>
                                    <td>{{ $score->student_id }}</td>
                                    <td>{{ $score->student->name }}</td>
                                    <td>{{ getSexText($score->student->sex) }}</td>
                                    <td>{{ $score->student->speciality->name }}</td>
                                    <td>
                                        @if($score->regular_score)
                                            {{ $score->regular_score }}
                                        @else
                                            {!! Form::number('regular_score',$score->regular_score,['class'=>'form-control','max'=>100,'min'=>0,'required']) !!}
                                        @endif
                                    </td>
                                    <td>
                                        @if($score->exam_score)
                                            {{ $score->exam_score }}
                                        @else
                                            {!! Form::number('exam_score',$score->exam_score,['class'=>'form-control','max'=>100,'min'=>0,'required']) !!}
                                        @endif
                                    </td>
                                    <td><span class="score">{{ $score->score }}</span></td>
                                    <td>
                                        @if(!$score->score)
                                            <button class="btn btn-success save" data-course="{{ $score->course_id }}" data-id="{{ $score->student_id }}">保存</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
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