@extends('app')

@section('title')
    予約一覧
@endsection

@section('content')

@include('layouts.nav')
<h1>予約画面です。</h1>
<reservation-time-table></reservation-time-table>
@endsection