<?php

namespace Modules\Admin\Rules;

use Illuminate\Contracts\Validation\Rule;

class PublicCervantMatricule implements Rule
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
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return is_int(preg_match("/^((\d{5,6})|(\d{10,12}))[a-zA-Z#]{1}$/", $value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ce matricule n\'est pas valide';
    }
}
