<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $guarded = [];
    private static $getList = null;

    public static function getListAll($location)
    {
        if (self::$getList === null) {
            self::$getList = self::where('location', $location)->pluck('text', 'code');
        }
        return self::$getList;
    }

    /**
     * Get all positions
     *
     * @return void
     */
    public static function getPosition()
    {
        return self::groupBy('position')->pluck('position')->all();
    }

    /**
     * Get all
     *
     * @param [type] $lang
     * @param [type] $position
     * @return void
     */
    public static function getLanguagesPosition($lang, $position, $keyword = null)
    {
        if (!empty($lang)) {
            $languages = ShopLanguage::getCodeAll();
            if (!in_array($lang, array_keys($languages))) {
                return  [];
            }
            $data =  self::where('location', $lang);
            if (!empty($position)) {
                $data = $data->where('position', $position);
            }
            if (!empty($keyword)) {
                $data = $data->where(function($query) use($keyword) {
                    $query->where('code', 'like', '%'.$keyword.'%')
                          ->orWhere('text', 'like', '%'.$keyword.'%');
                });
            }
            $data = $data->get()
            ->keyBy('code')
            ->toArray();
            return $data;
        } else {
            return [];
        }
    }
}
