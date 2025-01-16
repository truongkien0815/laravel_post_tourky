<?php
#App\Plugins\Total\Discount\Admin\AdminController.php

namespace App\Plugins\Total\Discount\Admin;

use App\Plugins\Total\Discount\Admin\Models\AdminDiscount;
use App\Http\Controllers\Controller;
use App\Model\ShopLanguage;
use App\Plugins\Total\Discount\AppConfig;
use App\Plugins\Total\Discount\Models\ShopDiscountStore;
use SCart\Core\Admin\Models\AdminStore;
use Validator;
class AdminController extends Controller
{
    public $plugin;
    public $title_head = 'Discount';

    public function __construct()
    {
        parent::__construct();
        $this->languages = ShopLanguage::getListActive();
        $this->plugin = new AppConfig;
    }

    public function index()
    {
        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => 'ID giảm dần',
            'id__asc' => 'ID tăng dần',
            'code__desc' => 'Mã giảm dần',
            'code__asc' => 'Mã tăng dần',
        ];
        $dataSearch = [
            'keyword'    => $keyword,
            'sort_order' => $sort_order,
            'arrSort'    => $arrSort,
        ];

        $discounts = (new AdminDiscount)->getDiscountListAdmin($dataSearch);

        $dataReponse = [
            'posts'  => $discounts,
            'title'  => $this->title_head,
            'url_action'  => route('admin_discount.create'),
            'url_list'  => route('admin_discount'),
            'url_delete_list'  => route('admin_discount.delete'),
        ];

        return view($this->plugin->pathPlugin.'::admin_index', $dataReponse);
    }

/**
 * Form create new
 * @return [type] [description]
 */
    public function create()
    {
        $data = [
            'title' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.add_new_title'),
            'subTitle' => '',
            'title_description' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'discount' => [],
            'url_action' => sc_route_admin('admin_discount.post'),
        ];
        return view($this->plugin->pathPlugin.'::admin_single')
            ->with($data);
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $discount = AdminDiscount::getDiscountAdmin($id);
        if (!$discount) {
            return redirect()->route('admin.data_not_found')->with(['url' => url()->full()]);
        }

        $data = [
            'title'             => sc_language_render($this->plugin->pathPlugin.'::lang.admin.edit'),
            'subTitle'          => '',
            'title_description' => '',
            'icon'              => 'fa fa-pencil-square-o',
            'discount'          => $discount,
            'url_action'        => sc_route_admin('admin_discount.post'),
        ];
        return view($this->plugin->pathPlugin.'::admin_single')
            ->with($data);
    }

    /**
     * update
     */
    public function post()
    {
        $data = request()->all();
        $post_id = $data['id'];

        $discount_unique = 'discount_unique';
        if($post_id)
            $discount_unique = 'discount_unique:'. $post_id;

        $validator = Validator::make($data, [
            'code'   => 'required|regex:/(^([0-9A-Za-z\-\._]+)$)/|' . $discount_unique . '|string|max:50',
            'limit' => 'required|numeric|min:1',
            'reward' => 'required|numeric|min:0',
            'type' => 'required',
        ], [
            'code.regex' => sc_language_render($this->plugin->pathPlugin.'::lang.admin.code_validate'),
            'code.discount_unique' => sc_language_render($this->plugin->pathPlugin.'::lang.discount_unique'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //Edit
        $dataUpdate = [
            'code'       => $data['code'],
            'reward'     => (int)$data['reward'],
            'limit'      => $data['limit'],
            'type'       => $data['type'],
            'data'       => $data['data'],
            'login'      => empty($data['login']) ? 0 : 1,
            'status'     => empty($data['status']) ? 0 : 1,
        ];
        if(!empty($data['expires_at'])) {
            $dataUpdate['expires_at'] = $data['expires_at'];
        }
        $dataUpdate = sc_clean($dataUpdate, [], true);

        $discount = AdminDiscount::getDiscountAdmin($post_id);
        // dd($post_id);
        if (!$discount) {
            $discount = AdminDiscount::createDiscountAdmin($dataUpdate);
        }
        else
        {
            $discount->update($dataUpdate);
        }

        $save = $data['submit'] ?? 'apply';
        if($save=='apply')
        {
            $url = route('admin_discount.edit', $discount->id);
            return redirect($url);
        }
        else
            return redirect(route('admin_discount'));

    }

    /*
    Delete list item
    Need mothod destroy to boot deleting in model
    */
    public function deleteList()
    {
        $arrID = request('post_list');
        // $arrID = explode(',', $ids);
        $arrDontPermission = [];
        foreach ($arrID as $key => $id) {
            if(!$this->checkPermisisonItem($id)) {
                $arrDontPermission[] = $id;
            }
        }
        /*if (count($arrDontPermission)) {
            return response()->json(['error' => 1, 'msg' => sc_language_render('admin.remove_dont_permisison') . ': ' . json_encode($arrDontPermission)]);
        }*/
        AdminDiscount::destroy($arrID);
        return response()->json(['error' => 0, 'msg' => '']);
    
    }

    /**
     * Check permisison item
     */
    public function checkPermisisonItem($id) {
        return AdminDiscount::getDiscountAdmin($id);
    }
}
