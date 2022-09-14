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
                <button class="btn btn-warning btn-sm rounded-3 me-3" data-bs-toggle="modal" data-bs-target="#Modal_edit{{$reserve->id}}">変更</button>
                <button class="btn btn-danger btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#Modal_remove{{$reserve->id}}">削除</button>
            </td>
        </tr>
        <!-- 変更用Modal Bootstrap5のモーダルコンポーネントから -->
        <div class="modal fade" id="Modal_edit{{$reserve->id}}" tabindex="-1" aria-labelledby="ModalLabel{{$reserve->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel_edit{{$reserve->id}}">予約変更</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="my_edit{{$reserve->id}}" method="POST" action="/myreserve/edit">
                <input form="my_edit{{$reserve->id}}" type="hidden" name="_token" value="{{ csrf_token() }}">
                <input form="my_edit{{$reserve->id}}" type="hidden" name="id" value="{{$reserve->id}}">
                <textarea class="mt-2" form="my_edit{{$reserve->id}}" placeholder="{{$reserve->memo}}"  name="memo"cols="70" rows="5">{{$reserve->memo}}</textarea>
            </form>
            <div class="modal-footer">
                <button form="my_edit{{$reserve->id}}" type="submit" class="btn btn-warning">
                      変更する
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
            </div>
            </div>
        </div>
        </div>
        <!-- 削除確認用Modal Bootstrap5のモーダルコンポーネントから -->
        <div class="modal fade" id="Modal_remove{{$reserve->id}}" tabindex="-1" aria-labelledby="ModalLabel{{$reserve->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel_remove{{$reserve->id}}">【{{$reserve->car->name}}】{{$reserve->start_at}}〜{{$reserve->end_at}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                この予約を削除しますが、よろしいですか？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                <form id="my_remove{{$reserve->id}}" method="POST" action="/myreserve/remove">
                    <input form="my_remove{{$reserve->id}}" type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input form="my_remove{{$reserve->id}}" type="hidden" name="id" value="{{$reserve->id}}">
                    <button form="my_remove{{$reserve->id}}" type="submit" class="btn btn-danger">
                          削除する
                    </button>
                </form>
            </div>
            </div>
        </div>
        </div>
        <!-- モーダルおわり -->
        @endforeach
    </table>

</div>
@endsection