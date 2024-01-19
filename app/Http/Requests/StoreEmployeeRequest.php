<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'name' => ['required', 'max:150'],
            'address' => ['sometimes', 'nullable'],
            'id_card_number' => ['required', 'numeric', 'digits_between:0,50'],
            'photo' => ['required', 'image'],

            'educations' => ['required', 'array'],
            'educations.*.school_name' => ['required', 'max:150'],
            'educations.*.major' => ['required', 'max:150'],
            'educations.*.entry_year' => ['required', 'date_format:Y'],
            'educations.*.graduation_year' => ['required', 'date_format:Y'],

            'work_experiences' => ['required', 'array'],
            'work_experiences.*.company_name' => ['required', 'max:150'],
            'work_experiences.*.position' => ['required', 'max:100'],
            'work_experiences.*.year' => ['required', 'integer'],
            'work_experiences.*.description' => ['sometimes', 'nullable'],
        ];
    }
}
