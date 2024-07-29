<?php

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class TryRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void 
    {
        // Thực hiện kiểm tra logic tùy ý ở đây
        // Nếu giá trị không hợp lệ, bạn có thể sử dụng $fail để thêm thông báo lỗi
        if ($value !== 'khoi') {
            $fail("Giá trị của trường $attribute không hợp lệ.");
        }
    }
}
