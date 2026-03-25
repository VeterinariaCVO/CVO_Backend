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
        $user = auth()->user();

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
            'owner_id'      => in_array($user->role_id, [1, 2, 4]) ? 'required|integer|exists:users,id' : 'nullable',
            'active'        => 'nullable|boolean',
        ];
    }
}
