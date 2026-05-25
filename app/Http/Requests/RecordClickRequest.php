<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordClickRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Mã sản phẩm không được để trống',
            'product_id.exists' => 'Mã sản phẩm không tồn tại trong hệ thống',
        ];
    }
}
