<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SalesOrder;

class Book extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'books';
    protected $fillable = ['name','category_name','price','image'];

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }
}
