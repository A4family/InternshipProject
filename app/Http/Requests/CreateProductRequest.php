<?php
declare(strict_types=1);

namespace App\Http\Requests;

use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'user_id' => ['required', 'bail', 'exists:users,id'],
            'product_title' => ['required', 'bail'],
            'product_description' => ['required', 'bail'],
            'product_price' => ['required', 'bail'],
            'product_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'parent_category' => ['required', 'bail'],
            'sub_category' => ['required', 'bail'],
            'sub_sub_category' => ['required', 'bail'],
            'product_tags' => ['required', 'bail', 'array'],
        ];

        if ($this->route()->named('product-update') || $this->route()->named('api.product-update')) {
            $rules['product_image'] = ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
        }
        return $rules;
    }
}
