<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stall extends Model
{
    use HasFactory;
    protected $table = 'stalls';
    protected $fillable = ['name','location','owner_name'];
}
