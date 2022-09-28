<?php

namespace App\Http\Requests;

use App\Rules\CheckTimeRule;
use App\Rules\ReservationRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    // 開始日時を$this->start_at,終了日時を$this->end_atとして取得できるようにしている。
    // またCarbonで整形することによりend_hourが24時を超える場合にも対応
    public function all($key = null)
    {
        $results = parent::all($key);
        // Carbonを用いて整形
        $results['start_at'] = $results['start_date'] .' '.$results['start_hour'].':'.$results['start_mint'];
        // 暫定的実装（nullでない場合にCarbonで整形）
        if(isset($results['start_hour']) && isset($results['start_mint'])){
            $results['start_at'] = new Carbon($results['start_at']);
        };
        $results['end_at'] = $results['end_date'] .' '.$results['end_hour'].':'.$results['end_mint'];
        if(isset($results['start_hour']) && isset($results['start_mint'])){
            $results['end_at'] = new Carbon($results['end_at']);
        };
        return $results;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'car_sel' => 'required', // 本来はexistsを入れるべき
            'start_date' => 'required|date',
            'start_hour' => 'required',
            'start_mint' => 'required',
            'end_date' => 'required|date',
            'end_hour' => 'required',
            'end_mint' => 'required',
            'memo' => 'required',
            'start_at' => [
                new CheckTimeRule(
                    $this->start_date, // 開始[日]
                    $this->start_hour, // 開始[時]
                    $this->start_mint, // 開始[分]
                    $this->end_date, // 終了[日]
                    $this->end_hour, // 終了[時]
                    $this->end_mint // 終了[分]
                ),
                new ReservationRule(
                    $this->car_sel, // carsテーブルのid
                    $this->start_at, // 開始日時
                    $this->end_at // 終了日時
                )
            ]
        ];
    }
}
