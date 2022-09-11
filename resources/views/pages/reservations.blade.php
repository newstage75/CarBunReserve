@extends('app')

@section('title')
    予約一覧
@endsection

@section('content')

@include('layouts.nav')
<div class="m-3">
<h1>Vue予約画面</h1>
<!-- 将来的にはカレンダーを常に表示して選択できるようにしたい。 -->
<form method="GET" action="/reservation">
    <label for="start">日付選択:</label>
    <input type="date" id="calendar_date" name="calendar_date">
    <button type="submit" class="ms-3">日付を切替える</button>
</form>

<reservation-time-table></reservation-time-table>
<reserve-form-component></reserve-form-component>
    <div class="m-3">
        <!-- 完了メッセージ -->
        @if (session('result'))
            <div style="color:green;">
                {{ session('result') }}
            </div>
            <br>
        @endif
        <!-- エラー表示 -->
        @if($errors->any())
            <div style="color:red;">
                【エラー】<br>
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
            <br>
        @endif
    </div>
</div>
@endsection