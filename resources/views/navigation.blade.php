<nav role="navigation">
    <div class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {!! Html::link(route('index'),'学生信息管理系统',['class'=>'navbar-brand']) !!}
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    @foreach($navigation as $parent)
                        @if(isset($parent['children']))
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $parent['title'] }}<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    @foreach($parent['children'] as $val)
                                        <li><a href="{!! $val['url'] !!}">{{ $val['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li><a href="{!! $parent['url'] !!}">{{ $parent['title'] }}</a></li>
                        @endif
                    @endforeach
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ request()->user['name'] }}<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>{!! Html::link(route('user:logout'),trans('template.exit')) !!}</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>