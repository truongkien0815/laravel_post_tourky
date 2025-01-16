<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopPaymentMethod extends Model
{
    public $timestamps = true;
    // protected $table = 'shop_payment_method';
    protected $guarded =[];

    protected static $getListTitleAdmin = null;
    protected static $getListCategoryGroupByParentAdmin = null;

    protected static $listActiveAll = null;

    public static function getListActive()
    {
        if (!self::$listActiveAll) {
            self::$listActiveAll = self::where('status', 1)->where('parent', 0)->get();
        }
        return self::$listActiveAll;
    }

    public function categories()
    {
        return $this->hasMany(ShopPaymentMethod::class, 'id', 'parent');
    }

    public function posts()
    {
        return $this->hasMany(ShopPaymentMethod::class, 'parent', 'id');
    }


    public function method()
    {
        return $this->hasMany('\App\Model\ShopPaymentMethodItem', 'method_id', 'id');
    }

    public function setting()
    {
        return $this->hasMany('\App\Model\ShopPaymentMethodSetting', 'method_id', 'id');
    }



    public static function getListTitleAdmin()
    {        
        if (self::$getListTitleAdmin === null) {
            self::$getListTitleAdmin = self::select('*')
            ->pluck('name', 'id')
            ->toArray();
        }
        return self::$getListTitleAdmin;
        
    }

    /**
     * Get tree categories
     *
     * @param   [type]  $parent      [$parent description]
     * @param   [type]  &$tree       [&$tree description]
     * @param   [type]  $categories  [$categories description]
     * @param   [type]  &$st         [&$st description]
     *
     * @return  [type]               [return description]
     */
    public function getTreeCategoriesAdmin($parent = 0, &$tree = [], $categories = null, &$st = '')
    {
        $categories = $categories ?? $this->getListCategoryGroupByParentAdmin();
        $categoriesTitle =  $this->getListTitleAdmin();

        $tree = $tree ?? [];
        $lisCategory = $categories[$parent] ?? [];
        if ($lisCategory) {
            foreach ($lisCategory as $category) {
                $tree[$category['id']] = $st . ($categoriesTitle[$category['id']]??'');
                if (!empty($categories[$category['id']])) {
                    $st .= '--';
                    $this->getTreeCategoriesAdmin($category['id'], $tree, $categories, $st);
                    $st = '';
                }
            }
        }
        return $tree;
    }

    /**
     * Get array title category
     * user for admin
     *
     * @return  [type]  [return description]
     */
    public static function getListCategoryGroupByParentAdmin()
    {
        if (self::$getListCategoryGroupByParentAdmin === null) {
            self::$getListCategoryGroupByParentAdmin = self::select('id', 'parent')
            ->get()
            ->groupBy('parent')
            ->toArray();
        }
        return self::$getListCategoryGroupByParentAdmin;
    }
}
