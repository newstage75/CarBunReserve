<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ReservationRule implements Rule
{

    private $_car_sel,
            $_start_at,
            $_end_at;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($car_sel, $start_at, $end_at)
    {
        $this->_car_sel = $car_sel;
        $this->_start_at = $start_at;
        $this->_end_at = $end_at;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    //このメソッドでtrueを返せば、このバリデーションは通過する。
    public function passes($attribute, $value)
    {
        return \App\Models\Reservation::where('car_id', $this->_car_sel)
        ->whereHasReservation($this->_start_at, $this->_end_at)
        ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '他の予約が入っています。';
    }
}
