<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'due_date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'status' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!in_array($value, TaskStatus::values())) {
                    $fail("The selected $attribute is invalid.");
                }
            }],
        ];
    }
}
