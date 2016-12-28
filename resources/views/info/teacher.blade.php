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
            {!! Html::link('#addTeacher','添加教师',['class'=>'btn btn-success add','data-toggle'=>'modal']) !!}
            {!! Form::open(['method'=>'get','class'=>'pull-right','role'=>'search']) !!}
            <div class="form-group col-xs-5">
                {!! Form::select('id',$speciality,request('id'),['class'=>'form-control','placeholder'=>'全部']) !!}
            </div>
            <div class="form-group col-xs-5">
                {!! Form::text('search',request('search'),['class'=>'form-control','placeholder'=>'教师名称']) !!}
            </div>
            {!! Form::submit('搜索',['class'=>'btn btn-default col-xs-2']) !!}
            {!! Form::close() !!}
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>姓名</th>
                <th>性别</th>
                <th>出生日期</th>
                <th>职称</th>
                <th>学院</th>
                <th>专业</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($teacher as &$val)
                <tr>
                    <td>{{ $val->id }}</td>
                    <td>{{ $val->name }}</td>
                    <td data-sex="{{ $val->sex }}">{{ getSexText($val->sex) }}</td>
                    <td>{{ $val->birthday }}</td>
                    <td data-title="{{ $val->title }}">{{ trans('template.teacher_title.'.$val->title) }}</td>
                    <td>{{ $val->speciality->department->name }}</td>
                    <td data-id="{{ $val->speciality_id }}">{{ $val->speciality->name }}</td>
                    <td>
                        <button class="btn btn-primary edit">编辑</button>
                        <button data-id="{{ $val->id }}" class="btn btn-default password">重置密码</button>
                        <button class="btn btn-danger delete">删除</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="alert alert-info">没有教师</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {!! $teacher->links() !!}
    </div>
    <div id="addTeacher" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">编辑教师</h4>
                </div>
                {!! Form::open(['id'=>'editForm']) !!}
                {!! Form::hidden('id') !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name','姓名',['class'=>'control-label']) !!}
                        {!! Form::text('name','',['class'=>'form-control','required']) !!}
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="checkbox-inline">
                                {!! Form::radio('sex',1,true) !!}{!! Html::nbsp() !!}男
                            </label>
                            <label class="checkbox-inline">
                                {!! Form::radio('sex',2) !!}{!! Html::nbsp() !!}女
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('birthday','出生日期',['class'=>'control-label','max'=>date('Y/m/d')]) !!}
                        {!! Form::date('birthday',null,['class'=>'form-control','required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('title','职称',['class'=>'control-label']) !!}
                        {!! Form::select('title',trans('template.teacher_title'),null,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('speciality_id','专业',['class'=>'control-label']) !!}
                        {!! Form::select('speciality_id',$speciality,null,['class'=>'form-control']) !!}
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
    <div id="resetPassword" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">重置密码</h4>
                </div>
                {!! Form::open(['method'=>'put']) !!}
                {!! Form::hidden('id') !!}
                <div class="modal-body">
                    {!! Form::label('password','密码',['class'=>'control-label']) !!}
                    {!! Form::password('password',['class'=>'form-control','required']) !!}
                </div>
                <div class="modal-footer">
                    {!! Form::submit('修改',['class'=>'btn btn-success']) !!}
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
                $('#addTeacher').modal('show');
                $(':hidden[name=id]').val(parent.find('td:eq(0)').text());
                $(':text[name=name]').val(parent.find('td:eq(1)').text());
                $(':radio[name=sex][value='+parent.find('td:eq(2)').data('sex')+']').prop('checked',true);
                $('input[name=birthday]').val(parent.find('td:eq(3)').text());
                $('select[name=title]').val(parent.find('td:eq(4)').data('title'));
                $('select[name=speciality_id]').val(parent.find('td:eq(6)').data('id'));
            });
            $('.delete').click(function(){
                let parent=$(this).parents('tr');
                confirmDialog('您确定要删除教师'+parent.find('td:eq(1)').text()+'？',function(res){
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
            $('.password').click(function(){
                let modal=$('#resetPassword');
                modal.modal('show');
                modal.find(':hidden[name=id]').val($(this).data('id'));
            });
        });
    </script>
@stop