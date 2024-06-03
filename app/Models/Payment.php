<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $dates = ['deleted_at'];
    protected $table = 'payments';
    protected $fillable = ['employee_id','total_price','accountno','bankname','ifsccode','payment_date','status','salary_type'];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
