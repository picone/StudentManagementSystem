@extends('vendor.layout')
@section('content')
    @include('navigation')
    <div class="container">
        <div class="col-xs-12">
            <a href="#addSpeciality" class="btn btn-success" data-toggle="modal">添加专业</a>
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
                <th>所属学院</th>
                <th>专业名称</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($speciality as &$val)
                <tr>
                    <td>{{ $val->id }}</td>
                    <td>{{ $val->department->name }}</td>
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
@stop
@section('js')
    <script>
        $(()=>{

        });
    </script>
@stop