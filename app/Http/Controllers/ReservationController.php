<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(Request $request) {
        //選択したカレンダーの日程でガントチャートの表示を反映させる。
        //選択されていない場合は、現在の年月日を取得する。
        $calendar_date = isset($request->calendar_date) ? $request->calendar_date : date("Y-m-d");
        // すべての車種情報を取得（セレクト用）
        $cars = Car::get();
        return view('pages.reservations',['calendar_date'=>$calendar_date,'cars'=>$cars]);
    }

    public function store(ReservationRequest $request){
        // $start_at=$request->start_date.' '.$request->start_hour.':'.$request->start_mint;
        // $end_at=$request->end_date.' '.$request->end_hour.':'.$request->end_mint;
        //ここで予約データ保存
        Reservation::create([
            'user_id'=> $request->user()->id,
            'car_id' => $request->car_sel,
            'memo' => $request->memo,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ]);
        // return view('pages.reservations');
        return back()->with('result', '予約が完了しました。');
    }

    //自身の予約確認用ページ
    public function myreserve(Request $request){
        $user = Auth()->user();
        $name = $user->name;
        $myreserve = Reservation::where('user_id',$user->id)->get();
        return view('pages.myreserve',['username'=>$name,'myreserve'=>$myreserve]);
    }

    public function edit(Request $request){
        $reserve = Reservation::find($request->id);
        //変更者一致かの認可
        $this->authorize('edit', $reserve);
        //データの変更部分
        $reserve->memo = $request->memo;
        $reserve->save();
        return redirect('/myreserve');
    }

    public function remove(Request $request){
        //変更者一致かの認可
        $reserve = Reservation::find($request->id);
        $this->authorize('edit', $reserve);
        //削除実行部分
        Reservation::destroy($request->id);
        return redirect('/myreserve');
    }

    //ユーザー別の予約確認用ページ
    public function other(Request $request){
        // すべてのユーザー情報を取得（セレクト用）
        $users = User::get();
        //クエリパラメータにidが含まれる場合はそのユーザidを。nullの場合は自身のユーザーidを。
        $select_id = $request->id == null  ? Auth()->user()->id : (int)$request->id;
        $username = User::where('id',$select_id)->first()->name;
        // 選択したユーザーの履歴取得
        $reserves = Reservation::where('user_id',$select_id)->get();
        return view('pages.users-reserve',['users'=>$users,'select_id'=>$select_id,'username'=>$username,'reserves'=>$reserves]);
    }

}
