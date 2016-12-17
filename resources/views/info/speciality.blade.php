@extends('vendor.layout')
@section('content')
    @include('navigation')
    <div class="container">
        <div class="col-xs-12">
            <a href="#addSpeciality" class="btn btn-success add" data-toggle="modal">添加专业</a>
            {!! Form::open(['method'=>'get','class'=>'pull-right','role'=>'search']) !!}
            <div class="form-group col-xs-5">
                {!! Form::select('id',$department,request('id'),['class'=>'form-control','placeholder'=>'全部']) !!}
            </div>
            <div class="form-group col-xs-5">
                {!! Form::text('search',request('search'),array('class'=>'form-control','placeholder'=>'专业名称')) !!}
            </div>
            {!! Form::submit('搜索',array('class'=>'btn btn-default col-xs-2')) !!}
            {!! Form::close() !!}
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>所属学院</th>
                <th>专业名称</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($speciality as &$val)
                <tr>
                    <td>{{ $val->id }}</td>
                    <td data-id="{{ $val->department_id }}">{{ $val->department->name }}</td>
                    <td>{{ $val->name }}</td>
                    <td>{{ $val->header }}</td>
                    <td>
                        <button class="btn btn-primary edit">编辑</button>
                        <button class="btn btn-danger delete">删除</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        <div class="alert alert-info">没有专业</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div id="addSpeciality" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">编辑专业</h4>
                </div>
                {!! Form::open(['id'=>'editForm']) !!}
                {!! Form::hidden('id') !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('department_id','所属学院',['class'=>'control-label']) !!}
                        {!! Form::select('department_id',$department,null,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('name','专业名称',['class'=>'control-label']) !!}
                        {!! Form::text('name','',['class'=>'form-control','required']) !!}
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
                $('#addSpeciality').modal('show');
                $(':hidden[name=id]').val(parent.find('td:eq(0)').text());
                $('select[name=department_id]').val(parent.find('td:eq(1)').data('id'));
                $(':text[name=name]').val(parent.find('td:eq(2)').text());
            });
            $('.delete').click(function(){
                let parent=$(this).parents('tr');
                confirmDialog('您确定要删除'+parent.find('td:eq(2)').text()+'？',function(res){
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