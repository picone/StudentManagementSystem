@extends('vendor.layout')
@section('content')
    @include('navigation')
    <div class="container">
        @if(Session::has('message'))
            <div class="alert alert-danger">
                {{ Session::get('message') }}
            </div>
        @endif
        {!! Form::open() !!}
            <div class="row">
                <div class="col-xs-6">
                    <button class="btn btn-success">保存</button>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="control-label">学期</label>
                        {!! Form::select('term',[1=>'第一学期',2=>'第二学期'],'',['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <ul class="list-group">
                    @foreach($course as $i=>&$val)
                        <li class="list-group-item">
                            <div class="radio">
                                <label><input type="radio" name="course" value="{{ $val->id }}" {{ $i==0?'checked':'' }}>{{ $val->name }}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-xs-12 col-sm-4">
                <ul class="list-group">
                    @foreach($speciality as $department=>$specialities)
                        <li class="list-group-item">{{ $department }}</li>
                        @foreach($specialities as $speciality_id=>$name)
                            <li class="list-group-item">
                                <div class="radio">
                                    <label><input type="radio" name="speciality" value="{{ $speciality_id }}">{{ $name }}</label>
                                </div>
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
            <div class="col-xs-12 col-sm-4">
                <ul class="list-group" id="student"></ul>
            </div>
        {!! Form::close() !!}
    </div>
@stop
@section('js')
    <script>
        $(()=>{
            $(':radio[name=speciality]').change(function(){
                $.getJSON('{!! route('course:student') !!}',{id:$(this).val()},function(data){
                    console.log(data);
                    if(data.code==1){
                        let str='';
                        $.each(data.data,function(i,v){
                            console.log(v);
                            str+='<li class="list-group-item"><label><input type="checkbox" name="student[]" value="'+v.id+'" checked>'+v.name+'</label></li>';
                        });
                        $('#student').html(str);
                    }else{
                        alert(data.msg);
                    }
                });
            });
        });
    </script>
@stop