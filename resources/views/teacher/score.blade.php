@extends('vendor.layout')
@section('content')
    @include('navigation')
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="col-xs-12 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">课程</div>
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($courses as $val)
                            <li class="list-group-item">{{ Html::link(route('teacher:score',['id'=>$val->id],false),$val->name) }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-9">
            @if($course!=null)
                <div class="panel panel-primary">
                    <div class="panel-heading">{{ $course->name }}</div>
                    <div class="panel-body">
                        <canvas id="chart" width="400" height="400"></canvas>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>学号</th>
                                <th>学生姓名</th>
                                <th>性别</th>
                                <th>平时成绩</th>
                                <th>期末成绩</th>
                                <th>总评成绩</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($score as $val)
                                <tr>
                                    <td>{{ $val->student_id }}</td>
                                    <td>{{ $val->student->name }}</td>
                                    <td>{{ $val->student->sex }}</td>
                                    <td>{{ $val->regular_score }}</td>
                                    <td>{{ $val->exam_score }}</td>
                                    <td>{{ $val->score }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $score->links() !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop
@section('js')
    <script>
        $(()=>{
            @if($course!=null)
                let ctx = $('#chart')[0].getContext('2d');
                new Chart(ctx,{
                    type:'pie',
                    data:{
                        labels:['不及格','60+','70+','80+','90+'],
                        datasets:[{
                            data:[{{ $chart->s1 }},{{ $chart->s2 }},{{ $chart->s3 }},{{ $chart->s4 }},{{ $chart->s5 }}],
                            backgroundColor:[
                                '#FF6384',
                                '#36A2EB',
                                '#FFCE56',
                                '#0FFF0E',
                                '#FF56B8'
                            ]
                        }]
                    }
                });
            @endif
        });
    </script>
@stop