<?php

namespace App\Rules;

use App\Models\Contract;
use Illuminate\Contracts\Validation\ImplicitRule;

class CanDeleteContractRule implements ImplicitRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
	protected Contract $contract ;
    public function __construct(Contract $contract)
    {
        $this->contract = $contract ;
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
		dd($value,$this->contract);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
