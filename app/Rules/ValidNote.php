<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\JsonResponse;

class ValidNote implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) < 10) {
            $fail(new JsonResponse(['message' => 'len must be longer.'], 400));
        }

        if (preg_match('/\d/', $value)) {
            $fail(new JsonResponse(['message' => 'dont use number'], 400 ));
        }
    }
}


// // Khai báo mảng với các phần tử boolean và string
// $myArray = [
//     true => 'This is true',
//     false => 'This is false',
// ];

// // Truy cập các phần tử trong mảng
// echo $myArray[true]; // In ra: "This is true"
// echo $myArray[false]; // In ra: "This is false"
