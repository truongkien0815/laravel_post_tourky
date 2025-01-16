<?php

namespace App\Http\Requests\Admin\PriceConfig;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePriceConfig extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.price-config.edit', $this->priceConfig);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'from' => ['nullable', 'integer'],
            'to' => ['nullable', 'integer'],
            'slug' => ['sometimes', Rule::unique('price_configs', 'slug')->ignore($this->priceConfig->getKey(), $this->priceConfig->getKeyName()), 'string'],
            'status' => ['sometimes', 'boolean'],

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
