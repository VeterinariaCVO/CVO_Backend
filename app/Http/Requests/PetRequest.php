<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'species'       => 'required|string',
            'breed'         => 'nullable|string',
            'color'         => 'nullable|string',
            'special_marks' => 'nullable|string',
            'weight'        => 'nullable|numeric',
            'sex'           => 'required|in:male,female',
            'age'           => 'nullable|integer',
            'photo'         => 'nullable|image|mimes:jpeg,png|max:5000',
            'owner_id'      => 'required|integer|exists:users,id',
            'active'        => 'nullable|boolean',
        ];
    }
}
