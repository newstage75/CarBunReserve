@extends('app')

@section('title')
    予約一覧
@endsection

@section('content')

@include('layouts.nav')
<reservation-time-table></reservation-time-table>
<reserve-form-component></reserve-form-component>
@endsection