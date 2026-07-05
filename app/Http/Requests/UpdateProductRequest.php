<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'name'                => 'required|string|max:255',
            'category_id'         => 'required|exists:categories,id',
            'price'               => 'nullable|numeric|min:0',
            'discount_price'      => 'nullable|numeric|min:0' . ($this->filled('price') ? '|lt:price' : ''),
            'stock'               => 'nullable|integer|min:0',
            'sku'                 => 'nullable|string|unique:products,sku,' . $productId,
            'period'              => 'nullable|string|max:255',
            'material'            => 'nullable|string|max:255',
            'condition'           => 'nullable|string|max:255',
            'origin'              => 'nullable|string|max:255',
            'content'             => 'nullable|string',
            'is_active'           => 'nullable|boolean',
            'availability_status' => 'nullable|string|in:in_stock,sold',
            'images.*'            => 'file|max:2048',
            'delete_images'       => 'nullable|array',
            'delete_images.*'     => 'exists:product_images,id',
            'main_image_id'       => 'nullable|exists:product_images,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'Vui lòng nhập tên sản phẩm',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'discount_price.numeric' => 'Giá khuyến mãi phải là số',
            'discount_price.min'     => 'Giá khuyến mãi không được nhỏ hơn 0',
            'discount_price.lt'      => 'Giá khuyến mãi phải nhỏ hơn giá gốc',
            'sku.unique'           => 'Mã SKU đã tồn tại',
        ];
    }
}
