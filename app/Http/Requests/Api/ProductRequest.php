<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        if(request()->route("product")) return $this->updating();

        return $this->creating();
    }

    private function updating()
    {
        return[
            "image" => [
                "bail",
                "url",
                function ($attribute, $value, \Closure $fail) {                    
                    $imageString = getimagesize($value);
                    if(!$imageString){
                        return $fail("The given image URL does not contain a valid image.");
                    }
                },
            ], 
            "brand" => [
                Rule::in(config("products.brands"))
            ], 
            "category" => [
                Rule::in(config("products.categories"))
            ], 
            "price" => "numeric|decimal:0,2",
            "discount" => "numeric|bail|prohibits:price_sale|min:0|max:100",
            "price_sale" => "bail|numeric|decimal:0,2|lte:".request()->input("price"),
            "stock" => "numeric",
        ];
    }

    private function creating()
    {
        return [
            "name" => "required",
            "image" => [
                "bail",
                "required",
                "url",
                function ($attribute, $value, \Closure $fail) {                    
                    $imageString = getimagesize($value);
                    if(!$imageString){
                        return $fail("The given image URL does not contain a valid image.");
                    }
                },
            ], 
            "brand" => [
                "required",
                Rule::in(config("products.brands"))
            ], 
            "category" => [
                "required",
                Rule::in(config("products.categories"))
            ], 
            "price" => "required|numeric|decimal:0,2",
            "discount" => "required_without:price_sale|numeric|bail|prohibits:price_sale|min:0|max:100",
            "price_sale" => "required_without:discount|bail|numeric|decimal:0,2|lte:".request()->input("price"),
            "stock" => "required|numeric",
        ];
    }

    public function messages()
    {
        return [
            "price_sale.required_without" => "The price sale is required",
            "price_sale.lte" => "The price sale must be lower than the original price",
            "discount.required_without" => "The discount is required",
            "discount.prohibits" => "You can only set the discount or the price_sale",
        ];
    }
}
