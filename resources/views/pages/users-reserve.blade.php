@extends('app')

@section('title')
   ユーザー別履歴
@endsection

@section('content')

@include('layouts.nav')
<div class="m-3">
    <section id="user-reserve-serch-form" class="p-2 bg-secondary">
        <p class="d-inline text-light">ユーザー名：</p>
        <form class="d-inline" action="/users" method="get">
            <select name="id">
                <option value="">選択してください</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}" @if($select_id === $user->id) selected @endif>{{$user->name}}</option>
                @endforeach
            </select>
            <button class="btn btn-light ms-2 p-0 ps-1 pe-1" type="submit">検索</button>
        </form>
    </section>

    <h4 class="mt-4">{{$username}}さんの予約ページ</h4>
    <table class="table table-striped">
        <tr>
            <th>日時</th>
            <th>車種</th>
            <th>使用用途・行き先など</th>
        </tr>
        @foreach ($reserves as $reserve)
        <tr>
            <td class="td-text">{{$reserve->start_at}}〜{{$reserve->end_at}}</td>
            <td class="td-text">{{$reserve->car->name}}</td>
            <td class="td-text">{{$reserve->memo}}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection