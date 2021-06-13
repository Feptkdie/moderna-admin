<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MidLine implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        $permissions = explode("-", $value);
        if (count($permissions) == 2) {
            if (empty($permissions[0]) || empty($permissions[1])) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function message()
    {
        return "The :attribute must be midline.";
    }
}
