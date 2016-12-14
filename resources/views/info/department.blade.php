@extends('vendor.layout')
@section('content')
    @include('navigation')
    <div class="container">
        <div class="col-xs-12">
            <a href="#add-department" class="btn btn-success" data-toggle="modal">添加学院</a>
            <form class="pull-right" role="search">
                <div class="form-group col-xs-9">
                    <input type="text" name="search" value="{{ request()->input('search') }}" placeholder="学院名称或领导人" class="form-control">
                </div>
                <button class="btn btn-default col-xs-3">搜索</button>
            </form>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>学院名称</th>
                <th>院长</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($department as &$val)
                <tr>
                    <td>{{ $val->id }}</td>
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
                        <div class="alert alert-info">没有学院</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div id="add-department" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">编辑学院</h4>
                </div>
                <form method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="control-label">学院名称</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="header" class="control-label">院长</label>
                            <input type="text" id="header" name="header" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success">保存</button>
                        <button type="button" class="btn" data-dismiss="modal">关闭</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(()=>{
            $('.edit').click(function(){
                let parent=$(this).parents('tr');
                $('#add-department').modal('show');
                $(':hidden[name=id]').val(parent.find('td:eq(0)').text());
                $(':text[name=name]').val(parent.find('td:eq(1)').text());
                $(':text[name=header]').val(parent.find('td:eq(2)').text());
            });
            $('.delete').click(function(){
                let parent=$(this).parents('tr');
                confirmDialog('您确定要删除'+parent.find('td:eq(1)').text()+'？',function(res){
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