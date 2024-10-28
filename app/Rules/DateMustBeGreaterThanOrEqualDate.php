<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class DateMustBeGreaterThanOrEqualDate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
	public $largerOrEqualDate , $date ,$failedMessage ; 
	
    public function __construct(?string $largerOrEqualDate , string $date,string $failedMessage)
    {
        $this->largerOrEqualDate = $largerOrEqualDate;
        $this->date = $date;
		$this->failedMessage = $failedMessage;
		
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
		if(is_null($this->largerOrEqualDate)){
			$this->largerOrEqualDate = $value;
		}
        return Carbon::make($this->largerOrEqualDate)->greaterThanOrEqualTo(Carbon::make($this->date));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->failedMessage;
    }
}
