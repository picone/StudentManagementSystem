@extends('vendor.layout')
@section('content')
    @include('navigation')
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                {{ Session::get('message') }}
            </div>
        @endif
        <div class="col-xs-12">
            {!! Html::link('#addCourse','添加课程',['class'=>'btn btn-success add','data-toggle'=>'modal']) !!}
            {!! Form::open(['method'=>'get','class'=>'pull-right','role'=>'search']) !!}
            <div class="form-group col-xs-5">
                {!! Form::select('id',$speciality,request('id'),['class'=>'form-control','placeholder'=>'全部']) !!}
            </div>
            <div class="form-group col-xs-5">
                {!! Form::text('search',request('search'),['class'=>'form-control','placeholder'=>'课程名称']) !!}
            </div>
            {!! Form::submit('搜索',['class'=>'btn btn-default col-xs-2']) !!}
            {!! Form::close() !!}
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>课程名</th>
                <th>学时</th>
                <th>学分</th>
                <th>任课老师</th>
                <th>所属专业</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($course as &$val)
                <tr>
                    <td>{{ $val->id }}</td>
                    <td>{{ $val->name }}</td>
                    <td>{{ $val->hour }}</td>
                    <td>{{ $val->credit }}</td>
                    <td data-id="{{ $val->teacher_id }}">{{ $val->teacher->name }}</td>
                    <td>{{ $val->teacher->speciality->name }}</td>
                    <td>
                        <button class="btn btn-primary edit">编辑</button>
                        <button class="btn btn-danger delete">删除</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="alert alert-info">没有课程</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {!! $course->links() !!}
    </div>
    <div id="addCourse" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">编辑课程</h4>
                </div>
                {!! Form::open(['id'=>'editForm']) !!}
                {!! Form::hidden('id') !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name','课程名',['class'=>'control-label']) !!}
                        {!! Form::text('name','',['class'=>'form-control','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('hour','学时',['class'=>'control-label']) !!}
                        {!! Form::number('hour','',['min'=>1,'class'=>'form-control','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('credit','学分',['class'=>'control-label']) !!}
                        {!! Form::number('credit','',['min'=>1,'class'=>'form-control','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('teacher_id','任课老师',['class'=>'control-label']) !!}
                        {!! Form::select('teacher_id',$teacher,null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit('保存',['class'=>'btn btn-success']) !!}
                    <button type="button" class="btn" data-dismiss="modal">关闭</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(()=>{
            $('.add').click(function(){
                $(':hidden[name=id]').val(0);
                $('#editForm')[0].reset();
            });
            $('.edit').click(function(){
                let parent=$(this).parents('tr');
                $('#addCourse').modal('show');
                $(':hidden[name=id]').val(parent.find('td:eq(0)').text());
                $(':text[name=name]').val(parent.find('td:eq(1)').text());
                $('input[name=hour]').val(parent.find('td:eq(2)').text());
                $('input[name=credit]').val(parent.find('td:eq(3)').text());
                $('select[name=teacher_id]').val(parent.find('td:eq(4)').data('id'));
            });
            $('.delete').click(function(){
                let parent=$(this).parents('tr');
                confirmDialog('您确定要删除课程'+parent.find('td:eq(1)').text()+'？',function(res){
                    if(res){
                        $.ajax({
                            url:location.pathname+'/'+parent.find('td:eq(0)').text(),
                            type:'DELETE',
                            success:function(data){
                                alertDialog(data.msg,data.code==1?0:1);
                                if(data.code==1){
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop