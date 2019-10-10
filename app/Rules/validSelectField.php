<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class validSelectField implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $message = null;
    public function __construct()
    {

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
        $fieldSelect = config('constants.field_select');
        foreach ($fieldSelect as $key => $value) {
            if(!in_array($key, $fieldSelect)){
                $this->message[] = 'Please select a column as the ' . $value;
            }
        }
        if ($this->message != null) {
            return false;
        } else {
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
        return $this->message;
    }
}
