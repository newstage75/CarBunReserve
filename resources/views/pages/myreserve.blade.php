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
                <button class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#Modal{{$reserve->id}}">削除</button>
            </td>
        </tr>
        <!-- 削除確認用Modal Bootstrap5のモーダルコンポーネントから -->
        <div class="modal fade" id="Modal{{$reserve->id}}" tabindex="-1" aria-labelledby="ModalLabel{{$reserve->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel{{$reserve->id}}">【{{$reserve->car->name}}】{{$reserve->start_at}}〜{{$reserve->end_at}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                この予約を削除しますが、よろしいですか？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                <form id="my_remove{{$reserve->id}}" method="POST" action="/myreserve/remove">
                    @csrf
                    <input type="hidden" name="_token" :value="csrf"></input>
                    <input type="hidden" name="id" value="{{$reserve->id}}"></input>
                    <button form="my_remove{{$reserve->id}}" type="submit" class="btn btn-danger">
                          削除する
                    </button>
                </form>
            </div>
            </div>
        </div>
        </div>
        @endforeach
    </table>

</div>
@endsection