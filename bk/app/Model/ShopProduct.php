<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LocalizeController;
use App\Model\ShopCategory;

class ShopProduct extends Model
{
    use LocalizeController;

    public $timestamps = true;
    protected $table = 'shop_products';
    protected $fillable = [
        'admin_id',
        'user_id',
        'name',
        'slug',
        'description',
        'content',
        'body',
        'name_en',
        'description_en',
        'content_en',
        'spec_short',
        'image',
        'cover',
        'cover_mobile',
        'icon',
        'gallery',
        'status',
        'sort',
        'stock',
        'price',
        'promotion',
        'price_type',
        'unit',
        'date_start',
        'date_end',
        'sku',
        'barcode',
        'expiry',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'updated_at',
        'created_at',
        'hot',
        'trend',
    ];
    protected $cast = [
        'meta' => 'array',
        'meta_en' => 'array'
    ];

    public function getUser()
    {
        $user = \App\User::find($this->user_id);
        if($user)
            return $user->name;
    }

    /*user detail*/
    public function getUserPost()
    {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

    public function admin(){
        return $this->belongsTo('App\Model\Admin', 'admin_id', 'id');
    }

    public function categories(){
        return $this->belongsToMany(ShopCategory::class, 'shop_product_category', 'product_id', 'category_id');
    }

    public function types(){
        return $this->belongsToMany(ShopType::class, 'shop_product_type', 'product_id', 'type_id');
    }

    public function getOption(){
        return $this->hasOne(\App\Model\ShopProductOption::class, 'product_id', 'id');
    }

    public function listClass()
    {
        return array(
            'out-product'   => 'Ngoại thất',
            'in-product'   => 'Nội thất',
            'engine-product'   => 'Động cơ, An toàn',
            'operation-product'   => 'Vận hành',
        );
    }

    public function getAttr()
    {
        return $this->hasMany('\App\Model\ShopProductAttr', 'product_id', 'id');
    }

    
    /**
     * Get value tax (%)
     *
     * @return  [type]  [return description]
     */
    public function getTaxValue()
    {
        return 0;
    }

    /*
    Upate stock, sold
    */
    public static function updateStock($product_id, $qty_change)
    {
        $item = self::find($product_id);
        if ($item) {
            $item->stock = $item->stock - $qty_change;
            $item->sold = $item->sold + $qty_change;
            $item->save();

            //Process build
            $product = self::find($product_id);
            if ($product->kind == SC_PRODUCT_BUILD) {
                foreach ($product->builds as $key => $build) {
                    $productBuild = $build->product;
                    $productBuild->stock -= $qty_change * $build->quantity;
                    $productBuild->sold += $qty_change * $build->quantity;
                    $productBuild->save();
                }
            }
        }
    }

    // admin
    /**
     * Get list product select in admin
     *
     * @param   array  $dataFilter  [$dataFilter description]
     *
     * @return  []                  [return description]
     */
    public function getProductSelectAdmin(array $dataFilter = [], $storeId = null)
    {
        $keyword          = $dataFilter['keyword'] ?? '';
        $limit            = $dataFilter['limit'] ?? '';
        $kind             = $dataFilter['kind'] ?? [];
        $tableDescription = (new ShopProductDescription)->getTable();
        $tableProduct     = $this->getTable();
        $tableProductStore = (new ShopProductStore)->getTable();
        $colSelect = [
            'id',
            'sku',
             $tableDescription . '.name'
        ];
        $productList = (new ShopProduct)->select($colSelect)
            ->leftJoin($tableDescription, $tableDescription . '.product_id', $tableProduct . '.id')
            ->leftJoin($tableProductStore, $tableProductStore . '.product_id', $tableProduct . '.id')
            ->where($tableDescription . '.lang', sc_get_locale());

        if ($storeId) {
            // Only get products of store if store <> root or store is specified
            $productList = $productList->where($tableProductStore . '.store_id', $storeId);
        }

        if (is_array($kind) && $kind) {
            $productList = $productList->whereIn('kind', $kind);
        }
        if ($keyword) {
            $productList = $productList->where(function ($sql) use ($tableDescription, $tableProduct, $keyword) {
                $sql->where($tableDescription . '.name', 'like', '%' . $keyword . '%')
                    ->orWhere($tableProduct . '.sku', 'like', '%' . $keyword . '%');
            });
        }

        if ($limit) {
            $productList = $productList->limit($limit);
        }
        $productList->groupBy($tableProduct.'.id');
        $dataTmp = $productList->get()->keyBy('id');
        $data = [];
        foreach ($dataTmp as $key => $row) {
            $data[$key] = [
                'id' => $row['id'],
                'sku' => $row['sku'],
                'name' => addslashes($row['name']),
            ];
        }
        return $data;
    }
    // admin

}
