<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordStrength implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Pastikan panjang password mencapai minimum tertentu
        if (strlen($value) < 8) {
            $fail('Panjang password minimal 8 karakter.');
        }

        // Pastikan ada setidaknya satu huruf besar
        if (!preg_match('/[A-Z]/', $value)) {
            $fail('Password harus mengandung setidaknya satu huruf besar.');
        }

        // Pastikan ada setidaknya satu huruf kecil
        if (!preg_match('/[a-z]/', $value)) {
            $fail('Password harus mengandung setidaknya satu huruf kecil.');
        }

        // Pastikan ada setidaknya satu karakter khusus (misalnya: @, #, $, dll.)
        if (!preg_match('/[@$!#%*?&]/', $value)) {
            $fail('Password harus mengandung setidaknya satu karakter khusus. (@$!#%*?&)');
        }
    }
}
