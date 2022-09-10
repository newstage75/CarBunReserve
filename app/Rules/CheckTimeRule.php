<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckTimeRule implements Rule
{

    private $_start_at,
            $_end_at;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start_at, $end_at)
    {
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
    public function passes($attribute, $value)
    {
        return $this->_start_at < $this->_end_at;
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
