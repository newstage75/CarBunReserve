<?php

namespace App\Http\Requests;

use App\Rules\ReservationRule;
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

    // all()内では開始日時を$this->start_at,終了日時を$this->end_atとして取得できるようにオーバーライド
    // 将来実装
    public function all($key = null)
    {
        $results = parent::all($key);
        $results['start_at'] = $results['start_date'] .' '.$results['start_hour'].':'.$results['start_mint'];
        $results['end_at'] = $results['end_date'] .' '.$results['end_hour'].':'.$results['end_mint'];
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
                new ReservationRule(
                    $this->car_sel, // carsテーブルのid
                    $this->start_at, // 開始日時
                    $this->end_at // 終了日時
                )
            ]
        ];
    }
}
