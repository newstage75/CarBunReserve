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
            <td class="td-text">{{$reserve->start_at}}〜{{$reserve->end_at}}</td>
            <td class="td-text">{{$reserve->car->name}}</td>
            <td class="td-text">{{$reserve->memo}}</td>
            <td>
                <button class="btn btn-warning btn-sm rounded-pill me-5">変更</button>
                <button class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#exampleModal">削除</button>
            </td>
        </tr>
        <!-- 削除確認用Modal Bootstrap5のモーダルコンポーネントから -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">社有車予約削除</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                「この」予約を削除しますが、よろしいですか？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                <button type="button" class="btn btn-danger">削除する</button>
            </div>
            </div>
        </div>
        </div>
        @endforeach
    </table>

</div>
@endsection