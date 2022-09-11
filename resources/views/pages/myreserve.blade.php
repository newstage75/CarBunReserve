@extends('app')

@section('title')
    My予約変更・削除
@endsection

@section('content')

@include('layouts.nav')
<div class="m-3">
    <h1>{{$username}}さんの予約ページ</h1>
    <table class="table table-striped">
        <tr>
            <th>日時</th>
            <th>車種</th>
            <th>使用用途・行き先など</th>
            <th></th>
        </tr>
        @foreach ($myreserve as $reserve)
        <tr>
            <td>{{$reserve->start_at}}〜{{$reserve->end_at}}</td>
            <td>{{$reserve->car_id}}</td>
            <td>{{$reserve->memo}}</td>
            <td></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection