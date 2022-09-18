<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductMaterial extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'seo_name',
        'active'
    ];

    /**
     * Связь материалы - продукты
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Product');
    }
}
