<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Middleware handles this
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                => 'required|string|max:255',
            'category_id'         => 'required|exists:categories,id',
            'price'               => 'required|numeric|min:0',
            'stock'               => 'nullable|integer|min:0',
            'sku'                 => 'nullable|string|unique:products,sku',
            'period'              => 'nullable|string|max:255',
            'material'            => 'nullable|string|max:255',
            'condition'           => 'nullable|string|max:255',
            'origin'              => 'nullable|string|max:255',
            'content'             => 'nullable|string',
            'is_active'           => 'nullable|boolean',
            'availability_status' => 'nullable|string|in:in_stock,sold,display',
            'images.*'            => 'file|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'Vui lòng nhập tên sản phẩm',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists'   => 'Danh mục không hợp lệ',
            'price.required'       => 'Vui lòng nhập giá sản phẩm',
            'price.numeric'        => 'Giá phải là số',
            'sku.unique'           => 'Mã SKU đã tồn tại',
            'images.*.image'       => 'File tải lên phải là hình ảnh',
            'images.*.max'         => 'Ảnh không được vượt quá 2MB',
        ];
    }
}
