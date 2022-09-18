<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrdersList extends BaseModel
{


    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'name',
        'email',
        'post_department',
        'city',
        'pay_now',
        'phone',
        'address',
        'comment',
        'total_cost',
        'status',
        'promocode',
    ];

    /**
     * Связь заказы - юзеры
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    /**
     * Связь заказы - продукты
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany('App\Models\Product');
    }

    /**
     * Связь заказы - элементы заказов
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany("App\Models\OrderListItem");
    }

    /**
     * Свзяь заказы - статусы заказов
     * @return HasOne
     */
    public  function status(): HasOne
    {
        return $this->hasOne(StatusList::class, 'id', 'status');
    }

    /**
     * Получение заказов по айди юзера и статусу заказа
     * @param int $user_id
     * @param int $status
     * @return Builder[]|Collection
     */
    public static function getUserOrdersByUserIdAndStatus(int $user_id, int $status): Collection|array
    {
        return self::query()
            ->where('user_id', $user_id)
            ->where('status', $status)
            ->get();
    }

    /**
     * Получение заказов юзера
     * @param int $user_id
     * @param int $status
     * @return Builder[]|Collection
     */
    public static function getUserOrders(int $user_id): Collection|array
    {
        return self::query()
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->orderBy('status', 'asc')
            ->get();
    }


    /**
     * Updating count of every product size and +1 to product popularity
     *
     * @return void
     */
    public function updateProductsProperties(): void
    {
        foreach($this->items as $item){

            $item->product->updateSizesCount($item->size, $item->count);

            $item->product->updateTotalCountAndPopularity($item->count);
        }
    }
}
