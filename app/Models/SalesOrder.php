<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Book;
use App\Models\Stall;
use Illuminate\Support\Facades\DB;

class SalesOrder extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'salesorders';
    protected $fillable = ['book_id','stall_id','location','sales_price','quantity','total_price'];

    public function stall()
    {
        return $this->belongsTo(Stall::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function scopeMonthlySales($query)
    {
        return $query->select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total_sales')
        )
        ->whereNull('deleted_at')
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'));
    }
}
