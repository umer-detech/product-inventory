<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTranslationRequest extends FormRequest
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
        $translation = $this->route('translation');
        $id = $translation->id;
        return [
            'key' => 'required|string|max:255|unique:translations,key' . ($id ? ',' . $id : ''),
            'locale' => 'required|string|max:5',
            'value' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'string'
        ];
    }
}
