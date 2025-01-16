<?php

namespace App\Http\Requests\Admin\Package;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePackage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.package.edit', $this->package);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'package_name' => ['sometimes', 'string'],
            'package_price' => ['sometimes'],
            'days' => ['sometimes', 'integer'],
            'status' => ['sometimes', 'boolean'],
            'is_default' => ['sometimes', 'boolean'],

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
