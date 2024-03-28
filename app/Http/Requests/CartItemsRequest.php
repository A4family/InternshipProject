<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartItemsRequest extends FormRequest
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
        if ($this->route()->named('change-cart-item-quantity')){
            return [
                'cart_id' => ['required', 'bail', 'integer'],
                'quantity' => ['required', 'integer', 'min:1'],
                'price' => ['required', 'numeric'],
            ];
        }
        return [
            'buyer_id' => ['required', 'bail', 'integer'],
            'seller_id' => ['required', 'bail', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
            'product_id' => ['required', 'bail', 'integer'],
            'price' => ['required', 'numeric'],
        ];
    }
}
