<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Brand extends Model
{
    use HasFactory;


    public function product()
    {
        return $this->hasMany(Product::class, 'brand_id')->where('status', 1)->whereDate('time_duration','>', Carbon::now()->toDateTimeString());
    }
}
