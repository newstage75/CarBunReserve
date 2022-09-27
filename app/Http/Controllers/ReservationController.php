<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index(Request $request) {
        // すべての車種情報を取得（セレクト用）
        $cars = Car::get();
        //選択したカレンダーの日程でガントチャートの表示を反映させる。
        //選択されていない場合は、現在の年月日を取得する。
        $calendar_date = isset($request->calendar_date) ? $request->calendar_date : date("Y-m-d");
        //選択された日付の予約状況を取得
        $reserved = Reservation::whereDate('start_at','<=',$calendar_date)->whereDate('end_at','>=',$calendar_date)->get();
        //予約状況を配列で取得する[車種id,時,分,自他の予約(0-1)]
        $reserve_block = [];
        foreach($reserved as $item) {
            // まず自分の予約か否かを判定
            $is_myself = Auth::id() == $item->user_id ? 0 : 1;
            // $calendar_dateと開始の日付を比較し、異なる場合は該当日の00:00:00に設定。
            $first = new Carbon($item->start_at); 
            $first_date = $first->format("Y-m-d");
            if($first_date < $calendar_date) {
                $first = Carbon::createMidnightDate($calendar_date);
            };
            //$calendar_dateと終了の日付を比較し異なる場合は該当日+1の00:00:00に設定。
            $second = new Carbon($item->end_at); 
            $second_date = $second->format("Y-m-d");
            if($second_date > $calendar_date) {
                $second = Carbon::createMidnightDate($calendar_date);
                $second->addDay();
            };
            // 開始時刻と終了時刻の差分（分）を計算
            $duration = $first->diffInMinutes($second);
            //['車種ID','時','分']のブロックを作成する
            $dt = $first;
            $blocks = intdiv($duration,15);
            //連想配列の作成
            for ($i = 0; $i < $blocks; $i++){
                $hour = $dt->hour;
                $mint = $dt->minute;
                //配列の作成
                $array = [$item->car_id, $hour, $mint,$is_myself];
                array_push($reserve_block, $array);
                $dt->addMinutes(15);
              }
        };

        return view('pages.reservations',['calendar_date'=>$calendar_date,'cars'=>$cars,'reserved'=>$reserved, 'reserve_block'=>$reserve_block]);
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
