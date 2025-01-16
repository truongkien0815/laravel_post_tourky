<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use SCart\Core\Admin\Models\AdminNews;
use SCart\Core\Admin\Models\AdminProduct;
use SCart\Core\Admin\Models\AdminCustomer;
use SCart\Core\Admin\Models\AdminOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public $templatePathAdmin;
    public function __construct()
    {
        parent::__construct();
        $this->templatePathAdmin = 'admin.';
    }
    
    public function index(Request $request)
    {
        
    }

    /**
     * Page not found
     *
     * @return  [type]  [return description]
     */
    public function dataNotFound()
    {
        $data = [
            'title' => sc_language_render('admin.data_not_found'),
            'icon' => '',
            'url' => session('url'),
        ];
        return view($this->templatePathAdmin.'data_not_found', $data);
    }


    /**
     * Page deny
     *
     * @return  [type]  [return description]
     */
    public function deny()
    {
        $data = [
            'title' => __('admin.deny'),
            'icon' => '',
            'method' => session('method'),
            'url' => session('url'),
        ];
        return view($this->templatePathAdmin.'deny', $data);
    }

    /**
     * [denySingle description]
     *
     * @return  [type]  [return description]
     */
    public function denySingle()
    {
        $data = [
            'method' => session('method'),
            'url' => session('url'),
        ];
        return view($this->templatePathAdmin.'deny_single', $data);
    }
}
