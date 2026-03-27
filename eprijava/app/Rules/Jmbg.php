<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Jmbg implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = (string) $value;

        if (!preg_match('/^\d{13}$/', $value)) {
            $fail('Матични број мора садржати тачно 13 цифара.');
            return;
        }

        $d = array_map('intval', str_split($value));

        $sum = 7 * ($d[0] + $d[6])
             + 6 * ($d[1] + $d[7])
             + 5 * ($d[2] + $d[8])
             + 4 * ($d[3] + $d[9])
             + 3 * ($d[4] + $d[10])
             + 2 * ($d[5] + $d[11]);

        $remainder = $sum % 11;
        $check = ($remainder === 0 || $remainder === 1) ? 0 : 11 - $remainder;

        if ($d[12] !== $check) {
            $fail('Матични број није исправан.');
        }
    }
}
