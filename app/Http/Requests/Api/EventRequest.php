<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'language' => 'required|string|max:50',
            'event_type' => 'required|string|in:online,offline',
            'location' => 'nullable|string|max:255',
            'online_link' => 'nullable|url',
            'is_paid' => 'required|boolean',
            'current_capacity' => 'nullable|integer|min:0',
            'max_capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Add specific rules for the update method
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules = array_map(function ($rule) {
                return str_replace('required', 'sometimes|required', $rule);
            }, $rules);
        }

        return $rules;
    }
}
