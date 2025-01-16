<?php
#App\Plugins\Total\Discount\Models\PluginModel.php
namespace App\Plugins\Total\Discount\Models;

use App\Model\ShopStore;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class PluginModel extends Model
{
    
    public $table = 'shop_discount';
    public $table_related = 'shop_discount_customer';
    protected $guarded    = [];
    protected $dates      = ['expires_at'];

    public function stores()
    {
        return $this->belongsToMany(ShopStore::class, ShopDiscountStore::class, 'discount_id', 'store_id');
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
    public function uninstall() {
        if (Schema::hasTable($this->table)) {
            Schema::drop($this->table);
        }
        if (Schema::hasTable($this->table_related)) {
            Schema::drop($this->table_related);
        }
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        /*static::deleting(function ($model) {
                $model->users()->detach();
                $model->stores()->detach();
            }
        );*/

        //Uuid
        /*static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_discount');
            }
        });*/
    }

    public function install()
    {
        $this->uninstall();

        Schema::create($this->table, function (Blueprint $table) {
            $table->id('id')->primary();
            $table->string('code', 50)->unique();
            $table->integer('reward')->default(2);
            $table->string('type', 10)->default('point')->comment('point - Point; percent - %');
            $table->string('data', 300)->nullable();
            $table->integer('limit')->default(1);
            $table->integer('used')->default(0);
            $table->integer('login')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create($this->table_related, function (Blueprint $table) {
            $table->uuid('customer_id')->index();
            $table->uuid('discount_id')->index();
            $table->text('log')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
        

    }
    /**
     * Get the users who is related promocode.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(\App\Model\ShopCustomer::class, $this->table_related, 'discount_id', 'customer_id')
            ->withPivot('used_at', 'log');
    }

    /**
     * Query builder to get expired promotion codes.
     *
     * @param $query
     * @return mixed
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')->whereDate('expires_at', '<=', Carbon::now());
    }

    /**
     * Check if code is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expires_at ? Carbon::now()->gte($this->expires_at) : false;
    }

    /**
     * [getPromotionByCode description]
     *
     * @param   [type]  $code  [$code description]
     *
     * @return  [type]         [return description]
     */
    public function getPromotionByCode($code) {
        $promotion = $this->where($this->getTable().'.code', $code);

        $promotion = $promotion->first();
        return $promotion;
    }
}
