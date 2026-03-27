<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SerbianCyrillic implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[\p{Cyrillic}\s\-,.\d]+$/u', (string) $value)) {
            $fail('Поље мора бити попуњено ћириличним словима.');
        }
    }
}
