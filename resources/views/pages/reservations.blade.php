@extends('app')

@section('title')
    予約一覧
@endsection

@section('content')

@include('layouts.nav')
<div class="m-3">
<div class="row">
    <div class="col-6">
        <h1>{{  $calendar_date  }}の予約状況</h1>
        <!-- 完了メッセージ -->
        <div class="m-3">
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
    <div class="col-6">
      <reserve-form-component :calendar-date='@json($calendar_date)' :cars-select='@json($cars)'></reserve-form-component>
    </div>
</div>
    <!-- 将来的にはカレンダーを常に表示して選択できるようにしたい。 -->
<div class="mb-1">
    <form method="GET" action="/reservation" class="d-inline-block">
        <label for="start">日付選択:</label>
        <input type="date" id="calendar_date" name="calendar_date" value="{{$calendar_date}}">
        <button type="submit" class="ms-3">日付を切替える</button>
    </form>
    <p class="d-float float-end align-text-bottom pt-2 mb-0">
        <span class="span-vacant">■</span>：空きあり　<span class="span-reserved">■</span>：空きなし　<span class="span-myself">■</span>：予約済み（ご自身）
    </p>
</div>
<reservation-time-table :cars-select='@json($cars)' :car-reserved='@json($reserved)' :reserve-block='@json($reserve_block)'></reservation-time-table>
</div>
@endsection