<?php

namespace App\Http\Requests;

use App\IngredientEnum;
use Illuminate\Foundation\Http\FormRequest;

class IngredientRequest extends FormRequest
{
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
        return [
            "ingredients" => "required|array",
            "ingredients.*.name"=> "required|string|distinct|min:1|in:". implode(',', array_column(IngredientEnum::cases(), 'value')),
            "ingredients.*.quantity"=> "required|numeric|min:1",
        ];
    }
}
