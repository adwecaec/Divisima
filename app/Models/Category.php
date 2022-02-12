<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
        'name',
        'seo_name',
        'active',
        'created_at',
        'updated_at',
        ];

    use Searchable;
    public function products() {
        return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }
    public function categoryGroups() {
        return $this->belongsToMany('App\Models\CategoryGroup');
    }

    public function subCategories(){
        return $this->hasMany('App\Models\SubCategory','category_id','id');
    }
}
