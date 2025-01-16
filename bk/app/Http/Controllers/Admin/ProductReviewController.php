<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use Auth, DB, File, Image, Config;
use Illuminate\Pagination\Paginator;
//review 
use App\Plugins\Cms\ProductReview\Admin\Models\AdminProductReview;

use Illuminate\Support\Facades\Log;

class ProductReviewController extends Controller
{
    public $data = [];
    public $admin_path = 'admin.review';
    public $title_head;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->title_head = __('Đánh giá');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $dataSearch = [
            'sort_order'    => 'id__desc'
        ];
        $reviews = (new AdminProductReview)->getReviewListAdmin($dataSearch);
        // dd($reviews);
        $dataReponse = [
            'reviews'  => $reviews,
            'title_head'  => $this->title_head,
            'url_create'  => '',
        ];
        return view($this->admin_path .'.index', $dataReponse);
    }

    public function edit($value='')
    {
        // code...
    }

    /**
     * Update status
     *
     * @return  [type]  [return description]
     */
    public function updateStatus() {
        $data = request()->all();
        $id = $data['id'];
        $status = $data['status'];
        try {
            AdminProductReview::where('id', $id)
                ->update(['status' => $status]);
            $error = 0;
            $msg = __('Success');
        } catch (\Throwable $e) {
            $error = 1;
            $msg = $e->getMessage();
        }
        return response()->json([
            'error' => $error,
            'status' => $status,
            'msg'   => $msg,
            ]
        );
    }
}
