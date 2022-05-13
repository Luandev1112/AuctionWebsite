<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{
    use HasFactory;


    public function specification()
    {
        return $this->hasMany(Specification::class,'category_id');
    }


    public function subCategory()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }


    public function product()
    {
        return $this->hasMany(Product::class, 'category_id')->where('status', 1)->whereDate('time_duration','>', Carbon::now()->toDateTimeString());
    }
}
