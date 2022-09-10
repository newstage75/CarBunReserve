@extends('app')

@section('title')
    予約一覧
@endsection

@section('content')

@include('layouts.nav')
<reservation-time-table></reservation-time-table>
<reserve-form-component></reserve-form-component>
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
            【エラー】<br><br>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        <br>
    @endif
@endsection