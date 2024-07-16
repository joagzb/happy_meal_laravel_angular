<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientsAvailableWebhookRequest extends FormRequest
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
        return [
            'ingredients' => 'required|array',
            'ingredients.*.name' => 'required|string|exists:ingredients,name',
            'ingredients.*.quantity' => 'required|integer|min:1',
            'ingredients.*.availability' => 'required|boolean',
        ];
    }
}
