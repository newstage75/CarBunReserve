<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index() {

        return view('pages.reservations');

    }

    //将来的にReservationRequestとしたいが、まずはRequestで実装
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
}
