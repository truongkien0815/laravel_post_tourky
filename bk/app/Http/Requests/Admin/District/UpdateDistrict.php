<?php

namespace App\Http\Requests\Admin\District;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateDistrict extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.district.edit', $this->district);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'type' => ['sometimes', 'string'],
            'lat' => ['nullable', 'string'],
            'lng' => ['nullable', 'string'],
            'slug' => ['sometimes', Rule::unique('districts', 'slug')->ignore($this->district->getKey(), $this->district->getKeyName()), 'string'],
            'city_id' => ['sometimes', 'integer'],
            
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
