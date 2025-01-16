<?php

namespace App\Http\Requests\Admin\CrawlerCateMapper;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\User;

class StoreCrawlerCateMapper extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.crawler-cate-mapper.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer'],
            'city_id' => ['required'],
            'district_id' => ['required'],
            'ward_id' => ['nullable'],
            'crawl_url' => ['required', 'string'],
            'activated' => ['required', 'boolean'],
            'is_first_time_crawled' => ['required', 'boolean'],
            'count_crawl' => ['required'],
            'page_first_crawl' => ['required'],
            'page_second_crawl' => ['required'],


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


        $sanitized['crawler_site_id'] = request()->route('crawlerSite');
        $sanitized['user_id'] = User::where('user_type', User::CRAWLER  )->first()->id;
        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
