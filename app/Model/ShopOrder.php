<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use DB;

class ShopOrder extends Model
{
    public $timestamps = true;
    protected $table = 'shop_order';
    protected $guarded =[];

    protected $sc_order_profile = 0; // 0: all, 1: only user's order
    public $sc_status = 1;

    public function getPayment()
    {
        return $this->hasOne(PaymentRequest::class, 'cart_id', 'id');
    }

    public function getPaymentMethodOrder()
    {
        return $this->hasOne(ShopPaymentMethod::class, 'code', 'payment_method');
    }
    public function getShippingOrder()
    {
        return $this->hasOne(ShippingPrice::class, 'code', 'shipping_method');
    }

    public function getProvince()
    {
        return $this->hasOne(LocationProvince::class, 'name', 'address1');
    }
    public function getDistrict()
    {
        return $this->hasOne(LocationDistrict::class, 'name', 'address2');
    }
    public function getWard()
    {
        return $this->hasOne(LocationWard::class, 'name', 'address3');
    }

    public function getAddressFull()
    {
        $address_full = implode(', ', array_filter([$this->cart_address , $this->ward, $this->district, $this->province]));
        return $address_full;
    }

    public function getLocation()
    {
        $province = $this->getProvince;
        $district = $this->getDistrict;
        $ward = $this->getWard;
        
        $provinces = LocationProvince::get()->pluck('name');
        $districts = LocationDistrict::where('province_id', $province->id??0)->get()->pluck('name');
        $wards = LocationWard::where('district_id', $district->id??0)->get()->pluck('type_name');

        return [
            'provinces' => $provinces,
            'districts' => $districts,
            'wards' => $wards,
        ];
    }

    public function details()
    {
        return $this->hasMany(ShopOrderDetail::class, 'order_id', 'id');
    }
    public function orderTotal()
    {
        return $this->hasMany(ShopOrderTotal::class, 'order_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo('SCart\Core\Front\Models\ShopCustomer', 'customer_id', 'id');
    }
    public function orderStatus()
    {
        return $this->hasOne(ShopOrderStatus::class, 'id', 'status');
    }
    public function paymentStatus()
    {
        return $this->hasOne(ShopPaymentStatus::class, 'id', 'payment_status');
    }
    public function history()
    {
        return $this->hasMany(ShopOrderHistory::class, 'order_id', 'id');
    }
    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($order) {
            foreach ($order->details as $key => $orderDetail) {
                //Update stock, sold
                ShopProduct::updateStock($orderDetail->product_id, -$orderDetail->qty);
            }

            $order->details()->delete(); //delete order details
            $order->orderTotal()->delete(); //delete order total
            $order->history()->delete(); //delete history
        });

        //Uuid
        /*static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_order');
            }
        });*/
    }

    /**
     * Create new order
     * @param  [array] $dataOrder
     * @param  [array] $dataTotal
     * @param  [array] $arrCartDetail
     * @return [array]
     */
    public function createOrder($dataOrder, $dataTotal, $arrCartDetail)
    {

        //Process escape
        $dataOrder     = sc_clean($dataOrder);
        $dataTotal     = sc_clean($dataTotal);
        $arrCartDetail = sc_clean($arrCartDetail);
        try {
            DB::connection(SC_CONNECTION)->beginTransaction();

            $dataOrder['domain'] = url('/');
            $uID = $dataOrder['customer_id'] ?? 0;
            $adminID = $dataOrder['admin_id'] ?? 0;
            unset($dataOrder['admin_id']);
            $currency = $dataOrder['currency'];
            $exchange_rate = $dataOrder['exchange_rate'];

            //Insert order
            $order = ShopOrder::create($dataOrder);
            // dd($order);
            $orderID = $order->id;
            // dd($orderID);
            // $count = ShopOrder::count();
            $code = auto_code('BB', $orderID);
            ShopOrder::where('id', $orderID)->update(['code' => $code]);
            //End insert order

            //Insert order total
            foreach ($dataTotal as $key => $row) {
                $row = sc_clean($row);
                // $row['id'] = sc_generate_id($type = 'shop_order_total');
                $row['order_id'] = $orderID;
                $row['created_at'] = sc_time_now();
                $dataTotal[$key] = $row;
            }
            // dd($orderID);
            ShopOrderTotal::insert($dataTotal);
            //End order total

            //Order detail
            foreach ($arrCartDetail as $cartDetail) {
                $pID = $cartDetail['product_id'];
                $product = ShopProduct::find($pID);
                
                //Check product flash sale over stock
                if (function_exists('sc_product_flash_check_over') && !sc_product_flash_check_over($pID, $cartDetail['qty'])) {
                    return $return = ['error' => 1, 'msg' => sc_language_render('cart.item_over_qty', ['sku' => $product->sku, 'qty' => $cartDetail['qty']])];
                }

                //If product out of stock
                if (!sc_config('product_buy_out_of_stock') && $product->stock < $cartDetail['qty']) {
                    return $return = ['error' => 1, 'msg' => sc_language_render('cart.item_over_qty', ['sku' => $product->sku, 'qty' => $cartDetail['qty']])];
                }
                //
                $tax = (sc_tax_price($cartDetail['price'], $product->getTaxValue()) - $cartDetail['price']) *  $cartDetail['qty'];

                $sku = $product->sku;
                if(!empty($cartDetail['attribute']) && count($cartDetail['attribute']))
                {
                    foreach($cartDetail['attribute'] as $groupAttr => $variable)
                    {
                        $attr_feature = explode('__', $groupAttr);
                        $item_id = $attr_feature[1]??0;
                        $feature_item = \App\Model\ShopProductItem::find($item_id);   
                        if($feature_item && $feature_item->sku !='')
                        {
                            $sku = $feature_item->sku;
                            break;
                        }
                    }
                }

                $cartDetail['order_id'] = $orderID;
                $cartDetail['currency'] = $currency;
                $cartDetail['exchange_rate'] = $exchange_rate;
                $cartDetail['sku'] = $sku;
                $cartDetail['tax'] = $tax;
                $cartDetail['store_id'] = $cartDetail['store_id'];
                $cartDetail['attribute'] = json_encode($cartDetail['attribute']);
                // dd($cartDetail);
                $this->addOrderDetail($cartDetail);

                //Update stock flash sale
                if (function_exists('sc_product_flash_update_stock')) {
                    sc_product_flash_update_stock($pID, $cartDetail['qty']);
                }

                //Update stock and sold
                ShopProduct::updateStock($pID, $cartDetail['qty']);
            }
            //End order detail

            //Add history
            $dataHistory = [
                'order_id' => $orderID,
                'content' => 'New order',
                'customer_id' => $uID,
                'admin_id' => $adminID,
                'order_status_id' => $order->status,
            ];
            $this->addOrderHistory($dataHistory);

            //Process Discount
            $totalMethod = session('totalMethod') ?? [];
            foreach ($totalMethod as $keyPlugin => $codeApply) {
                if ($codeApply) {
                    $moduleClass = sc_get_class_plugin_controller($code = 'Total', $key = $keyPlugin);
                    // dd($moduleClass);
                    $arrReturnModuleDiscount = (new $moduleClass)->apply($codeApply, $uID, $msg = 'Order #' . $orderID);
                    if ($arrReturnModuleDiscount['error'] == 1) {
                        $msg = $arrReturnModuleDiscount['msg'];
                        DB::connection(SC_CONNECTION)->rollBack();
                        $return = ['error' => 1, 'msg' => $msg];
                        return $return;
                    }
                }
            }

            // End process Discount
            DB::connection(SC_CONNECTION)->commit();

            // Process event created
            sc_event_order_created($order);

            $return = ['error' => 0, 'orderID' => $orderID, 'msg' => "", 'detail' => $order];
        } catch (\Throwable $e) {
            DB::connection(SC_CONNECTION)->rollBack();
            $return = ['error' => 1, 'msg' => $e->getMessage()];
        }
        return $return;
    }

    /**
     * Add order detail
     * @param [type] $dataDetail [description]
     */
    public function addOrderDetail($dataDetail)
    {
        return ShopOrderDetail::create($dataDetail);
    }

    /**
     * Add order history
     * @param [array] $dataHistory
     */
    public function addOrderHistory($dataHistory)
    {
        return ShopOrderHistory::create($dataHistory);
    }

    /**
     * Disable only user's order mode
     */
    public function setOrderProfile()
    {
        $this->sc_order_profile = 1;
        $this->sc_status = 'all' ;
        return $this;
    }

    public function profile()
    {
        $this->setOrderProfile();
        return $this;
    }

    /**
     * build Query
     */
    public function buildQuery()
    {
        $customer = auth()->user();
        if ($this->sc_order_profile == 1) {
            if (!$customer) {
                return null;
            }
            $uID = $customer->id;
            $query = $this->with('orderTotal')->where('customer_id', $uID);
        } else {
            $query = $this->with('orderTotal')->with('details');
        }

        if ($this->sc_status !== 'all') {
            $query = $query->where('status', $this->sc_status);
        }

        /**
        Note: sc_moreWhere will remove in the next version
         */
        if (count($this->sc_moreWhere)) {
            foreach ($this->sc_moreWhere as $key => $where) {
                if (count($where)) {
                    $query = $query->where($where[0], $where[1], $where[2]);
                }
            }
        }
        $query = $this->processMoreQuery($query);
        

        if ($this->random) {
            $query = $query->inRandomOrder();
        } else {
            if (is_array($this->sc_sort) && count($this->sc_sort)) {
                foreach ($this->sc_sort as  $rowSort) {
                    if (is_array($rowSort) && count($rowSort) == 2) {
                        $query = $query->sort($rowSort[0], $rowSort[1]);
                    }
                }
            }
        }

        return $query;
    }

    /**
     * Update value balance, received when order capture full money with payment method
     *
     * @return  [type]  [return description]
     */
    public function processPaymentPaid()
    {
        $total = $this->total;
        $this->balance = 0;
        $this->received = -$total;
        $this->save();
        (new ShopOrderTotal)
            ->where('order_id', $this->id)
            ->where('code', 'received')
            ->update(['value' =>  -$total]);
    }

    // admin
    /**
     * Get list order in admin
     *
     * @param   [array]  $dataSearch  [$dataSearch description]
     *
     * @return  [type]               [return description]
     */
    public static function getOrderListAdmin(array $dataSearch)
    {
        $keyword      = $dataSearch['keyword'] ?? '';
        $email        = $dataSearch['email'] ?? '';
        $from_to      = $dataSearch['from_to'] ?? '';
        $end_to       = $dataSearch['end_to'] ?? '';
        $sort_order   = $dataSearch['sort_order'] ?? '';
        $arrSort      = $dataSearch['arrSort'] ?? '';
        $order_status = $dataSearch['order_status'] ?? '';
        $storeId      = $dataSearch['storeId'] ?? '';

        $orderList = (new ShopOrder);
        
        if ($storeId) {
            $orderList = $orderList->where('store_id', $storeId);
        }

        if ($order_status) {
            $orderList = $orderList->where('status', $order_status);
        }
        if ($keyword) {
            $orderList = $orderList->where(function ($sql) use ($keyword) {
                $sql->Where('id', $keyword)
                    ->orWhere('code', $keyword)
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('phone', 'like', "%$keyword%");
            });
        }

        if ($email) {
            $orderList = $orderList->where(function ($sql) use ($email) {
                $sql->Where('email', 'like', '%'.$email.'%');
            });
        }

        if ($from_to) {
            $orderList = $orderList->where(function ($sql) use ($from_to) {
                $sql->Where('created_at', '>=', $from_to);
            });
        }

        if ($end_to) {
            $orderList = $orderList->where(function ($sql) use ($end_to) {
                $sql->Where('created_at', '<=', $end_to);
            });
        }

        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $orderList = $orderList->orderBy($field, $sort_field);
        } else {
            $orderList = $orderList->orderBy('created_at', 'desc');
        }
        $orderList = $orderList->paginate(20);

        return $orderList;
    }

    /**
     * Get order detail in admin
     *
     * @param   [type]  $id  [$id description]
     *
     * @return  [type]       [return description]
     */
    public static function getOrderAdmin($id, $storeId = null)
    {
        $data  = self::with(['details', 'orderTotal'])
        ->where('id', $id);
        if ($storeId) {
            $data = $data->where('store_id', $storeId);
        }
        return $data->first();
    }

    // admin
}
