<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Page;
use App\Model\Document;
use App\Model\DocumentCategory as Category;
use View;

class DocumentController extends Controller
{
    use \App\Traits\LocalizeController;
    
    public $data = [];
    public $paginate = 12;

    public function indexTemplate($slug) {
        $this->localized();
        $page = Page::where('slug', $slug)->first();
        $this->data['page'] = $page;
        $this->data['posts'] = (new Document)->getList([
            'paginate'  => $this->paginate
        ]);
        $this->data['seo'] = [
            'seo_title' => $page->seo_title!=''? $page->seo_title : $page->title,
            'seo_image' => $page->image,
            'seo_description'   => $page->seo_description ?? '',
            'seo_keyword'   => $page->seo_keyword ?? '',

        ];

        $templateName = 'theme.page.'.$page->template;

        if (View::exists($templateName))
            return view($templateName, ['data' => $this->data])->compileShortcodes();
        else
            return redirect(url('/'));
    }
    
    public function index() {
        $page = Page::findorfail(101);
        $dataResponse = [
            'title'  => $page->title,
            'page'  => $page,
            'posts'  => (new Document)->getList([
                'paginate'  => $this->paginate
            ]),
            'categories'  => Category::where('category_id', 0)->get(),
            'seo' => [
                'seo_title' => $page->seo_title!=''? $page->seo_title : $page->title,
                'seo_image' => $page->image,
                'seo_description'   => $page->seo_description ?? '',
                'seo_keyword'   => $page->seo_keyword ?? '',

            ]
        ];
        return view($this->templatePath .'.document.index', $dataResponse);
    }
    
    public function newsDetail($slug){
        $this->localized();
        $news = (new Document)->getDetail($slug, $type = 'slug');
        $page = Page::findorfail(3);
        if($page && $news)
        {
            $category = $news->categories->first();
            $this->data['category'] = $category;
            $this->data['page'] = $page;
            $this->data['category_child'] = Category::where('category_id', 1)->get();
            $this->data['news'] = $news;
            // $this->data['news_featured'] = News::orderbyDesc('id')->limit(3)->get();
            $tintuc = Category::find(1);
            $this->data['news_featured'] = (new Document)->setCategory($category->id)->getList(['limit'=> 6]);

            $this->data['seo'] = [
                'seo_title' => $news->seo_title!=''? $news->seo_title : $news->name,
                'seo_image' => $news->image,
                'seo_description'   => $news->seo_description ?? '',
                'seo_keyword'   => $news->seo_keyword ?? '',

            ];
//             dd($this->data['seo']);
            return view($this->templatePath .'.document.single', $this->data);
        }
        else
            return view('errors.404');
    }
    
    public function category($slug){
        $this->localized();
        $category = Category::where('slug', $slug)->first();

        if($category){
            $dataResponse = [
                'title'  => $category->name,
                'category'  => $category,
                'posts'  => (new Document)->setCategory($category->id)->getList([
                    'paginate'  => $this->paginate
                ]),
                'categories'  => Category::where('category_id', 0)->get(),
                'seo' => [
                    'seo_title' => $category->seo_title!=''? $category->seo_title : $category->title,
                    'seo_image' => $category->image,
                    'seo_description'   => $category->seo_description ?? '',
                    'seo_keyword'   => $category->seo_keyword ?? '',
                ]
            ];
            return view($this->templatePath .'.document.index', $dataResponse);
        }
        else
            return $this->newsDetail($slug);
    }
}
