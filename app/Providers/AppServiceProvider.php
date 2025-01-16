<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Harimayco\Menu\Facades\Menu;
use Illuminate\Support\Facades\View;
use Gornymedia\Shortcodes\Facades\Shortcode;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->registerRouteMiddleware();
    }   

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (glob(app_path() .'/Libraries/Helpers/*.php') as $filename) {
            require_once $filename;
        }
        
        view()->share('templatePath', env('APP_THEME', 'theme'));
        view()->share('templateFile', env('APP_THEME', 'theme'));

        //Load Plugin Provider
        try {
            foreach (glob(app_path() . '/Plugins/*/*/Provider.php') as $filename) {
                require_once $filename;
            }
        } catch (\Throwable $e) {
            $msg = '#SC004::Message: ' .$e->getMessage().' - Line: '.$e->getLine().' - File: '.$e->getFile();
            sc_report($msg);
            echo $msg;
            exit;
        }
        
        $this->bootCustom();
        //
        Shortcode::add('slider', function($atts, $id, $items=3) 
        {
            $data = Shortcode::atts([
                'id' => $id,
                'items' => $items
            ], $atts);

            $file = 'shortcode/slider' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        //
        Shortcode::add('banner', function($atts, $id, $id_dt='') 
        {
            $data = Shortcode::atts([
                'id' => $id,
                'id_dt' => $id_dt
            ], $atts);

            $file = 'shortcode/banner' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        //
        Shortcode::add('product_hot', function($atts, $items=3) 
        {
            $data = Shortcode::atts([
                'items' => $items
            ], $atts);

            $file = 'shortcode/product_hot' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        //
        Shortcode::add('product', function($atts, $category_id = 0, $items=4) 
        {
            $data = Shortcode::atts([
                'category_id' => $category_id,
                'items' => $items
            ], $atts);

            $file = 'shortcode/product' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        //
        Shortcode::add('news', function($atts, $category_id = 0, $limit=4, $show_items=3)
        {
            $data = Shortcode::atts([
                'category_id' => $category_id,
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/news' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });

        Shortcode::add('quy-trinh', function($atts, $category_id = 'quy-trinh', $limit=4, $show_items=3)
        {
            $data = Shortcode::atts([
                'id' => $category_id,
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/quy-trinh' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        
        Shortcode::add('product_new', function($atts, $limit=4, $show_items=3)
        {
            $data = Shortcode::atts([
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/product_new' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });

        Shortcode::add('about_new', function($atts,$limit=4, $show_items=3)
        {
            $data = Shortcode::atts([
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/about_new' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        Shortcode::add('service_home', function($atts,$category_id=4,$limit=4, $show_items=3)
        {
            $data = Shortcode::atts([
                'category_id' => $category_id,
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/service_home' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        Shortcode::add('service_home2', function($atts,$category_id=4,$limit=4, $show_items=3)
        {
            $data = Shortcode::atts([
                'category_id' => $category_id,
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/service_home2' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        Shortcode::add('service_home3', function($atts,$category_id=4,$limit=4, $show_items=3)
        {
            $data = Shortcode::atts([
                'category_id' => $category_id,
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/service_home3' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        Shortcode::add('service_home4', function($atts,$category_id=4,$limit=4, $show_items=3)
        {
            $data = Shortcode::atts([
                'category_id' => $category_id,
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/service_home4' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        Shortcode::add('service_home5', function($atts,$category_id=4,$limit=4, $show_items=3)
        {
            $data = Shortcode::atts([
                'category_id' => $category_id,
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/service_home5' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        Shortcode::add('map', function($atts,$limit=1, $show_items=3)
        {
            $data = Shortcode::atts([
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/map' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });

        Shortcode::add('contact', function($atts,$limit=1, $show_items=3)
        {
            $data = Shortcode::atts([
                'limit' => $limit,
                'show_items' => $show_items,
            ], $atts);

            $file = 'shortcode/contact' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
        
        
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }
    }


    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'currency' => \App\Http\Middleware\Currency::class
    ];

    public function bootCustom()
    {
        // view()->share('blocksContent', sc_store_block());
    }
}
