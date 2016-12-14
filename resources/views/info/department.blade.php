@extends('vendor.layout')
@section('content')
    @include('navigation')
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>学院名称</th>
                <th>院长</th>
            </tr>
            </thead>
            <tbody>
            @forelse($department as &$val)
                <tr>
                    <td>{{ $val-> }}</td>
                </tr>
            @empty()
                <tr>
                    <td colspan="3">
                        <div class="alert alert-info">没有学院</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@stop