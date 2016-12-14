@extends('vendor.layout')
@section('content')
    <div class="container-fluid" id="login">
        <div class="row">
            <div class="col-xs-12 col-md-4 col-md-offset-4">
                <div class="row">
                    <div class="login-title col-xs-12">
                        <h3 class="text-center">学生信息管理系统</h3>
                        <hr>
                    </div>
                    <div class="login-content col-xs-10 col-xs-offset-1">
                        <form class="form-horizontal" role="form" method="post">
                            {{ csrf_field() }}
                            @if(Session::has('message'))
                                <div class="alert alert-danger">
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="用户名" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="密码" required>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="checkbox-inline"><input type="radio" name="type" value="1" checked>&nbsp;管理员</label>
                                    <label class="checkbox-inline"><input type="radio" name="type" value="2">&nbsp;教师</label>
                                    <label class="checkbox-inline"><input type="radio" name="type" value="3">&nbsp;学生</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="remember" value="1" checked>&nbsp;记住登录</label>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-block btn-info">登录</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
