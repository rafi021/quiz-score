<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
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
            'title' => 'required|string|min:1|max:100',
            'subject_name' => 'required|string|min:1|max:100',
            'quiz_date' => 'required|date',
            'total_mark' => 'nullable|numeric',
            'pass_mark' => 'nullable|numeric',
        ];
    }
}
