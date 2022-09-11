<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index(Request $request) {
        //将来的に選択したカレンダーの日程でガントチャートの表示を反映させる。
        // $calendar_date = $request->calendar_date;
        // $laraArray = Reservation::where('start_at',$calendar_date)->get();
        // return view('pages.reservations')->with('laraArray', $laraArray);
        return view('pages.reservations');

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
        return view('pages.myreserve');
    }
}
