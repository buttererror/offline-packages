<?php

namespace App\Rules;

use App\Client;
use Illuminate\Contracts\Validation\Rule;

class AgeValidate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
      if(Client::getAge($value)>100||Client::getAge($value)<0)
        return false;
      else{
          return true;
      }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Age can not higher than 100 or lower than zero';
    }
}
