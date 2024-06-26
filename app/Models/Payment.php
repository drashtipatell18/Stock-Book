<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'payments';
    protected $fillable = ['employee_id','total_price','accountno','bankname','ifsccode','payment_date','status','salary_type','advance_payment','advance_payment_date'];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
