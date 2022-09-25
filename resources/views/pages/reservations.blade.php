@extends('app')

@section('title')
    予約一覧
@endsection

@section('content')

@include('layouts.nav')
<div class="m-3">
<h1>{{  $calendar_date  }}の予約状況</h1>
<!-- 将来的にはカレンダーを常に表示して選択できるようにしたい。 -->
<form method="GET" action="/reservation">
    <label for="start">日付選択:</label>
    <input type="date" id="calendar_date" name="calendar_date" value="{{$calendar_date}}">
    <button type="submit" class="ms-3">日付を切替える</button>
</form>

<reservation-time-table :cars-select='@json($cars)'></reservation-time-table>
<reserve-form-component :calendar-date='@json($calendar_date)' :cars-select='@json($cars)'></reserve-form-component>
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