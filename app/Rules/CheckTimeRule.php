<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckTimeRule implements Rule
{

    private $_start_date,
            $_start_hour,
            $_start_mint,
            $_end_date,
            $_end_hour,
            $_end_mint;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start_date, $start_hour, $start_mint, $end_date, $end_hour, $end_mint)
    {
        $this->_start_date = $start_date;
        $this->_start_hour = $start_hour;
        $this->_start_mint = $start_mint;
        $this->_end_date = $end_date;
        $this->_end_hour = $end_hour;
        $this->_end_mint = $end_mint;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($this->_start_date < $this->_end_date){
            return true;
        }elseif($this->_start_date == $this->_end_date){
            if($this->_start_hour < $this->_end_hour){
                return true;
            }elseif($this->_start_hour == $this->_end_hour){
                if($this->_start_mint < $this->_end_mint){
                    return true;
                }
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '予約時刻が逆転しています！';
    }
}
